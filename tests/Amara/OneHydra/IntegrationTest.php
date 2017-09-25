<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra;

use Amara\OneHydra\Http\HttpRequestBuilder;
use Amara\OneHydra\Http\HttpRequestInterface;
use Amara\OneHydra\Http\HttpResponse;
use Amara\OneHydra\Http\Transport\GuzzleTransport;
use Amara\OneHydra\Http\Transport\TransportInterface;
use Amara\OneHydra\ResultBuilder\PageResultBuilder;
use Amara\OneHydra\ResultBuilder\PagesResultBuilder;
use Amara\OneHydra\ResultBuilder\ResultBuilderEngine;
use GuzzleHttp\Client;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

class IntegrationTest extends PHPUnit_Framework_TestCase
{
    public function testGetPagesWithMockedTransport()
    {
        $isUat = false;
        $authToken = 'foo';

        $expectedPageUrls = ['https://www.example.com/foo', 'https://www.example.com/bar'];
        $head = '{"Head":[
            {"MetaDescription":"A meta description"},
            {"Title":"A title"}
        ]}';
        $body = '{"Pages":{
            "PageUrls":[
                "https:\/\/www.example.com\/foo",
                "https:\/\/www.example.com\/bar"
            ]
        }}';

        $responseMock = new HttpResponse();
        $responseMock->setHeaders(json_decode($head)->Head);
        $responseMock->setBody($body);

        $transportMock = $this->prophesize(TransportInterface::class);
        $transportMock->execute(Argument::that(
            function (HttpRequestInterface $httpRequest) use ($authToken) {
                return (
                    'https://seoapi.onehydra.com/v2/pages' === $httpRequest->getUrl() &&
                    [] == $httpRequest->getParams() &&
                    ['Authorization' => $authToken] == $httpRequest->getHeaders()
                );
            }
        ))->willReturn($responseMock);

        $httpRequestBuilder = new HttpRequestBuilder($isUat, $authToken);

        $resultBuilderEngine = new ResultBuilderEngine();
        $resultBuilderEngine->addBuilder(new PageResultBuilder());
        $resultBuilderEngine->addBuilder(new PagesResultBuilder());

        $api = new Api($httpRequestBuilder, $transportMock->reveal(), $resultBuilderEngine);

        $pagesResult = $api->getPagesResult();

        $expectedHttpResponse = new HttpResponse();
        $expectedHttpResponse->setHeaders(json_decode($head)->Head);
        $expectedHttpResponse->setBody($body);

        $this->assertEquals($expectedHttpResponse , $pagesResult->getHttpResponse());

        $this->assertEquals($expectedPageUrls, $pagesResult->getPageUrls());
    }
    
    public function testGetPageWithMockedTransport()
    {
        $isUat = false;
        $authToken = 'foo';
        $pageUrl = '/foo/bar';

        $body = '{"Page":{
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

        $responseMock = new HttpResponse();
        $responseMock->setBody($body);

        $transportMock = $this->prophesize(TransportInterface::class);
        $transportMock->execute(Argument::that(
            function (HttpRequestInterface $httpRequest) use ($authToken, $pageUrl) {
                return (
                    'https://seoapi.onehydra.com/v2/page' === $httpRequest->getUrl() &&
                    ['url' => $pageUrl] == $httpRequest->getParams() &&
                    ['Authorization' => $authToken] == $httpRequest->getHeaders()
                );
            }
        ))->willReturn($responseMock);

        $httpRequestBuilder = new HttpRequestBuilder($isUat, $authToken);

        $resultBuilderEngine = new ResultBuilderEngine();

        $api = new Api($httpRequestBuilder, $transportMock->reveal(), $resultBuilderEngine);

        $pageResult = $api->getPageResult($pageUrl);
        $page = $pageResult->getPage();

        $this->assertEquals('A meta description', $page->getHeadContent()->MetaDescription);
    }

    public function testGetPagesWithRealTransport()
    {
        $this->markTestSkipped("Ask OneHydra for sample endpoint?");

        $isUat = false;
        $authToken = 'foo';

        $httpRequestBuilder = new HttpRequestBuilder($isUat, $authToken);

        $guzzleClient = new Client();
        $transport = new GuzzleTransport($guzzleClient);

        $resultBuilderEngine = new ResultBuilderEngine();
        $resultBuilderEngine->addBuilder(new PageResultBuilder());
        $resultBuilderEngine->addBuilder(new PagesResultBuilder());

        $api = new Api($httpRequestBuilder, $transport, $resultBuilderEngine);

        $pagesResult = $api->getPagesResult();
        $pageResult = $api->getPageResult($pagesResult->getPageUrls()[0]);
    }
}