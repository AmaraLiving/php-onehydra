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
                "Key":"main links",
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
            },
            {
                "Key":"related links",
                "Value":[
                    {
                        "AnchorText":"Related link 1",
                        "DestinationUrl":"https:\/\/www.example.com\/related-link-1",
                        "Order":1
                    },
                    {
                        "AnchorText":"Related link 2",
                        "DestinationUrl":"https:\/\/www.example.com\/relatedlink-2",
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
            "RedirectTargetUrl":"https:\/\/www.example.com"
        }
    }}';

    private static $newBodyJson = '{"Page":{
        "HeadContent":{
            "MetaDescription":"A more meta description",
            "MetaKeywords":"Some extra meta keywords",
            "Title":"A better title"
        },
        "HeadInstructions":{
            "CanonicalUrl":"https://www.another.example.com/canonical",
            "MetaRobots":"RETURN, FOLLOW"
        },
        "Links":[
            {
                "Key":"Major Links",
                "Value":[
                    {
                        "AnchorText":"Major link 1",
                        "DestinationUrl":"https:\/\/www.another.example.com\/link-1",
                        "Order":1
                    },
                    {
                        "AnchorText":"Major link 2",
                        "DestinationUrl":"https:\/\/www.another.example.com\/link-2",
                        "Order":2
                    }
                ]
            }
        ],
        "PageContent":{
            "Abstract":"More abstract page content",
            "General":[{
                "Key":"Custard Field 1",
                "Value":"Custard Value 1"
            }],
            "H1":""
        },
        "Products": [
            {"ProductCode":"200"},
            {"ProductCode":"300"},
            {"ProductCode":"400"}
        ],
        "ServerSide":{
            "PageOrigin":"Suggested",
            "PreexistingUrl":true,
            "RedirectCode":503,
            "RedirectTargetUrl":"https:\/\/www.another.example.com"
        }
    }}';

    /**
     * @var Page
     */
    private $resultPage;

    /**
     * @var \stdClass
     */
    private $initialPageBody;

    /**
     * @var \stdClass
     */
    private $newPageBody;

    public function setUp() {
        $initialPageBody = json_decode(self::$bodyJson)->Page;

        $this->initialPageBody = $initialPageBody;
        $this->resultPage = new Page($initialPageBody);

        $this->newPageBody = json_decode(self::$newBodyJson)->Page;
    }

    /**
     * @covers Amara\OneHydra\Model\Page::getHeadContent
     * @covers Amara\OneHydra\Model\Page::getDescription
     * @covers Amara\OneHydra\Model\Page::getKeywords
     * @covers Amara\OneHydra\Model\Page::getTitle
     * @covers Amara\OneHydra\Model\Page::setHeadContent
     */
    public function testHeadContentGettersAndSetter()
    {
        $resultPage = $this->resultPage;

        $this->assertEquals($this->initialPageBody->HeadContent, $resultPage->getHeadContent());

        $this->assertEquals('A meta description', $resultPage->getDescription());
        $this->assertEquals('Some meta keywords', $resultPage->getKeywords());
        $this->assertEquals('A title', $resultPage->getTitle());

        $newHeadContent = $this->newPageBody->HeadContent;
        $resultPage->setHeadContent($newHeadContent);
        $this->assertEquals($newHeadContent, $resultPage->getHeadContent());
    }

    /**
     * @covers Amara\OneHydra\Model\Page::getHeadInstructions
     * @covers Amara\OneHydra\Model\Page::getCanonicalUrl
     * @covers Amara\OneHydra\Model\Page::getRobots
     * @covers Amara\OneHydra\Model\Page::setHeadInstructions
     */
    public function testHeadInstructionsGettersAndSetter()
    {
        $resultPage = $this->resultPage;

        $this->assertEquals($this->initialPageBody->HeadInstructions, $resultPage->getHeadInstructions());

        $this->assertEquals('https://www.example.com/canonical', $resultPage->getCanonicalUrl());
        $this->assertEquals('INDEX, FOLLOW', $resultPage->getRobots());

        $newHeadInstructions = $this->newPageBody->HeadInstructions;
        $resultPage->setHeadInstructions($newHeadInstructions);
        $this->assertEquals($newHeadInstructions, $resultPage->getHeadInstructions());

    }

    /**
     * @covers Amara\OneHydra\Model\Page::getLinks
     * @covers Amara\OneHydra\Model\Page::getMainLinks
     * @covers Amara\OneHydra\Model\Page::getRelatedLinks
     * @covers Amara\OneHydra\Model\Page::getLinkSection
     * @covers Amara\OneHydra\Model\Page::setLinks
     */
    public function testLinksGettersAndSetter()
    {
        $resultPage = $this->resultPage;

        $initialLinks = $this->initialPageBody->Links;

        $this->assertEquals($initialLinks, $resultPage->getLinks());

        $this->assertEquals($initialLinks[0]->Value, $resultPage->getMainLinks());
        $this->assertEquals($initialLinks[1]->Value, $resultPage->getRelatedLinks());

        $newLinks = $this->newPageBody->Links;
        $resultPage->setLinks($newLinks);
        $this->assertEquals($newLinks, $resultPage->getLinks());

        $this->assertEquals([], $resultPage->getRelatedLinks());
    }

    /**
     * @covers Amara\OneHydra\Model\Page::getPageContent
     * @covers Amara\OneHydra\Model\Page::getAbstract
     * @covers Amara\OneHydra\Model\Page::getH1
     * @covers Amara\OneHydra\Model\Page::setPageContent
     */
    public function testPageContentGettersAndSetter()
    {
        $resultPage = $this->resultPage;

        $this->assertEquals($this->initialPageBody->PageContent, $resultPage->getPageContent());

        $this->assertEquals('Page content abstract', $resultPage->getAbstract());
        $this->assertEquals('Page content H1', $resultPage->getH1());

        $newPageContent = $this->newPageBody->PageContent;
        $resultPage->setPageContent($newPageContent);
        $this->assertEquals($newPageContent, $resultPage->getPageContent());
    }

    /**
     * @covers Amara\OneHydra\Model\Page::getServerSide
     * @covers Amara\OneHydra\Model\Page::getRedirectCode
     * @covers Amara\OneHydra\Model\Page::getRedirectUrl
     * @covers Amara\OneHydra\Model\Page::setServerSide
     * @covers Amara\OneHydra\Model\Page::isSuggested
     */
    public function testServerSideGettersAndSetter()
    {
        $resultPage = $this->resultPage;

        $this->assertEquals($this->initialPageBody->ServerSide, $resultPage->getServerSide());

        // getRedirectCode
        $this->assertEquals('200', $resultPage->getRedirectCode());
        // getRedirectUrl
        $this->assertEquals('https://www.example.com', $resultPage->getRedirectUrl());

        // isSuggested where PageOrigin is not 'suggested'
        $this->assertFalse($resultPage->isSuggested());

        // setServerSide
        $newServerSide = $this->newPageBody->ServerSide;
        $resultPage->setServerSide($newServerSide);
        $this->assertEquals($newServerSide, $resultPage->getServerSide());

        // isSuggested where PageOrigin is 'suggested'
        $this->assertTrue($resultPage->isSuggested());
    }

    /**
     * @covers Amara\OneHydra\Model\Page::getPageUrl
     * @covers Amara\OneHydra\Model\Page::setPageUrl
     */
    public function testPageUrlGetterAndSetter()
    {
        $resultPage = $this->resultPage;
        $this->assertEmpty($resultPage->getPageUrl());
        $resultPage->setPageUrl('https://www.example.page.url.com');
        $this->assertEquals('https://www.example.page.url.com', $resultPage->getPageUrl());
    }
}