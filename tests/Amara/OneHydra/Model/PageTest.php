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

use Amara\OneHydra\Model\Page;
use Amara\OneHydra\Model\PageInterface;
use PHPUnit_Framework_TestCase;

class PageTest extends PHPUnit_Framework_TestCase
{
    private static $bodyJson = '{"Page":{
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

    public function testGetters()
    {
        $rawResult = json_decode(self::$bodyJson);

        $resultPage = new Page($rawResult->Page);

        $this->assertInstanceOf(PageInterface::class, $resultPage);

        // Head content
        $this->assertEquals("A meta description", $resultPage->getHeadContent()->MetaDescription);
        $this->assertEquals("Some meta keywords", $resultPage->getHeadContent()->MetaKeywords);
        $this->assertEquals("A title", $resultPage->getHeadContent()->Title);

        // Head instructions
        $this->assertEquals("https://www.example.com/canonical", $resultPage->getHeadInstructions()->CanonicalUrl);
        $this->assertEquals("INDEX, FOLLOW", $resultPage->getHeadInstructions()->MetaRobots);

        // Links
        $links = $resultPage->getLinks();
        $this->assertEquals('Main Links', $links[0]->Key);
        $this->assertEquals('Main link 1', $links[0]->Value[0]->AnchorText);
        $this->assertEquals('Main link 2', $links[0]->Value[1]->AnchorText);

        // Page content
        $this->assertEquals("Page content abstract", $resultPage->getPageContent()->Abstract);

        // Server side
        $this->assertEquals("Existing", $resultPage->getServerSide()->PageOrigin);
    }
}