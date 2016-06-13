<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Amara\OneHydra\Http\Transport;

use Amara\OneHydra\Http\HttpRequest;

/**
 * Class HttpRequestTest
 *
 * @package TestsAmara\OneHydra\Http\Transport
 * @coversDefaultClass Amara\OneHydra\Http\HttpRequest
 */
class HttpRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Amara\OneHydra\Http\HttpRequest::getMethod
     * @covers Amara\OneHydra\Http\HttpRequest::setMethod
     */
    public function testSetAndGetMethod()
    {
        $httpRequest = new HttpRequest();
        $this->assertNull($httpRequest->getMethod());
        $httpRequest->setMethod('get');
        $this->assertEquals('get', $httpRequest->getMethod());
    }

    /**
     * @covers Amara\OneHydra\Http\HttpRequest::getUrl
     * @covers Amara\OneHydra\Http\HttpRequest::setUrl
     */
    public function testSetAndGetUrl()
    {
        $httpRequest = new HttpRequest();
        $this->assertNull($httpRequest->getUrl());
        $httpRequest->setUrl('www.amara.com');
        $this->assertEquals('www.amara.com', $httpRequest->getUrl());
    }

    /**
     * @covers Amara\OneHydra\Http\HttpRequest::getParams
     * @covers Amara\OneHydra\Http\HttpRequest::setParams
     */
    public function testSetAndGetParams()
    {
        $httpRequest = new HttpRequest();
        $this->assertNull($httpRequest->getParams());
        $httpRequest->setParams(['test']);
        $this->assertEquals(['test'], $httpRequest->getParams());
    }

    /**
     * @covers Amara\OneHydra\Http\HttpRequest::getHeaders
     * @covers Amara\OneHydra\Http\HttpRequest::setHeaders
     */
    public function testSetAndGetHeaders()
    {
        $httpRequest = new HttpRequest();
        $this->assertNull($httpRequest->getHeaders());
        $httpRequest->setHeaders(['test']);
        $this->assertEquals(['test'], $httpRequest->getHeaders());
    }
    
}
