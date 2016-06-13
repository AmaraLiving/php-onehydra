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
use Amara\OneHydra\Http\HttpRequestBuilder;
use Amara\OneHydra\Request\RequestInterface;

class HttpRequestBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Amara\OneHydra\Http\HttpRequestBuilder::build
     */
    public function testBuild()
    {
        $request = $this->getRequestMock();

        $httpRequestBuilder = new HttpRequestBuilder(false, '');
        $httpRequest = $httpRequestBuilder->build($request);
        $this->assertInstanceOf(HttpRequest::class, $httpRequest);
        $this->assertEquals('https://seoapi.onehydra.com/v2/test', $httpRequest->getUrl());
        $this->assertEquals([], $httpRequest->getParams());
        $this->assertEquals(['Authorization' => ''], $httpRequest->getHeaders());
    }

    /**
     * @covers Amara\OneHydra\Http\HttpRequestBuilder::build
     */
    public function testBuildWithUat()
    {
        $request = $this->getRequestMock();

        $httpRequestBuilder = new HttpRequestBuilder(true, '');
        $httpRequest = $httpRequestBuilder->build($request);
        $this->assertInstanceOf(HttpRequest::class, $httpRequest);
        $this->assertEquals('https://uat.seoapi.onehydra.com/v2/test', $httpRequest->getUrl());
        $this->assertEquals([], $httpRequest->getParams());
        $this->assertEquals(['Authorization' => ''], $httpRequest->getHeaders());
    }

    /**
     * Gets a request mock
     *
     * @param string $serviceEndPoint
     * @return object
     */
    private function getRequestMock($serviceEndPoint = 'test')
    {
        $request = $this->prophesize(RequestInterface::class);
        $request->getParams()->willReturn([]);
        $request->getService()->willReturn($serviceEndPoint);
        $request->getAttributes()->willReturn([]);

        return $request->reveal();
    }
}
