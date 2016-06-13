<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra\ResultBuilder;

use Amara\OneHydra\Http\HttpResponseInterface;
use Amara\OneHydra\Model\PageInterface;
use Amara\OneHydra\Request\RequestInterface;
use Amara\OneHydra\Result\PageResult;
use PHPUnit_Framework_TestCase;

class PageResultBuilderTest extends PHPUnit_Framework_TestCase
{
    private static $responseBodyJson = '{"Page":{
        "HeadContent":{
            "MetaDescription":"A meta description",
            "MetaKeywords":"Some meta keywords",
            "Title":"A title"
        },
        "HeadInstructions":{
            "CanonicalUrl":"https:\/\/www.example.com\/canonical",
            "MetaRobots":"INDEX, FOLLOW"
        },
        "Links":[
            {
                "Key":"Main Links",
                "Value":[
                    {
                        "AnchorText":"Main link 1",
                        "DestinationUrl":"https:\/\/www.example.com\/link-1",
                        "Order":1
                    },
                    {
                        "AnchorText":"Main link 2",
                        "DestinationUrl":"https:\/\/www.example.com\/link-2",
                        "Order":2
                    }
                ]
            }
        ],
        "PageContent":{
            "Abstract":"Page content abstract",
            "General":[{
                "Key":"Custom Field 1",
                "Value":"Custom Value 1"
            }],
            "H1":"Page content H1"
        },
        "Products": [
            {"ProductCode":"200"},
            {"ProductCode":"300"},
            {"ProductCode":"400"}
        ],
        "ServerSide":{
            "PageOrigin":"Existing",
            "PreexistingUrl":null,
            "RedirectCode":200,
            "RedirectTargetUrl":null
        }
    }}';

    public function testBuildWhenAllOk()
    {
        $url = '/foo';

        $request = $this->prophesize(RequestInterface::class);
        $request->getParams()->willReturn(
            [
                'url' => $url,
            ]
        );

        $response = $this->prophesize(HttpResponseInterface::class);
        $response->getBody()->willReturn(self::$responseBodyJson);

        $builder = new PageResultBuilder();

        $result = $builder->build($request->reveal(), $response->reveal());

        $this->assertInstanceOf(PageResult::class, $result);

        $this->assertEquals($response->reveal(), $result->getHttpResponse(), "Response is passed through correctly");

        $resultPage = $result->getPage();


        $this->assertInstanceOf(PageInterface::class, $resultPage);

        // Compare the pages as JSON
        $expectedJson = json_encode(json_decode(self::$responseBodyJson)->Page);
        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($resultPage->getRawPage()));
    }

    /**
     * @dataProvider provideBuildWhenInvalidJson
     * @expectedException \Amara\OneHydra\Exception\ResultBuilderException
     */
    public function testBuildWhenInvalidJson($json)
    {
        $url = '/foo';

        $request = $this->prophesize(RequestInterface::class);
        $request->getParams()->willReturn(
            [
                'url' => $url,
            ]
        );

        $response = $this->prophesize(HttpResponseInterface::class);
        $response->getBody()->willReturn($json);

        $builder = new PageResultBuilder();

        $builder->build($request->reveal(), $response->reveal());
    }

    public function provideBuildWhenInvalidJson()
    {
        return [
            [
                $json = "{d",
            ],
            [
                $json = "{}",
            ],
            [
                $json = '{"Page":{}}',
            ],
        ];
    }
}