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


use Amara\OneHydra\Http\HttpResponse;

/**
 * Class HttpResponseTest
 *
 * @package Tests\Amara\OneHydra\Http\Transport
 * @coversDefaultClass Amara\OneHydra\Http\HttpResponse
 */
class HttpResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Amara\OneHydra\Http\HttpResponse::getHeaders
     * @covers \Amara\OneHydra\Http\HttpResponse::setHeaders
     */
    public function testSetAndGetHeaders()
    {
        $httpResponse = new HttpResponse();
        $this->assertNull($httpResponse->getHeaders());
        $httpResponse->setHeaders(['test']);
        $this->assertEquals(['test'], $httpResponse->getHeaders());
    }
    
    /**
     * @covers \Amara\OneHydra\Http\HttpResponse::getBody
     * @covers \Amara\OneHydra\Http\HttpResponse::setBody
     */
    public function testSetAndGetBody()
    {
        $httpResponse = new HttpResponse();
        $this->assertNull($httpResponse->getBody());
        $httpResponse->setBody('test');
        $this->assertEquals('test', $httpResponse->getBody());
    }

}
