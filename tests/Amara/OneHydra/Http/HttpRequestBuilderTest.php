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

    public function testBuildWithRequestAuthAttribute()
    {
        $authToken = 'authy';

        $request = $this->getRequestMock('test', ['auth_token' => $authToken]);

        $httpRequestBuilder = new HttpRequestBuilder(true, '');
        $httpRequest = $httpRequestBuilder->build($request);
        $this->assertInstanceOf(HttpRequest::class, $httpRequest);
        $this->assertEquals('https://uat.seoapi.onehydra.com/v2/test', $httpRequest->getUrl());
        $this->assertEquals([], $httpRequest->getParams());
        $this->assertEquals(['Authorization' => $authToken], $httpRequest->getHeaders());
    }

    /**
     * Gets a request mock
     *
     * @param string $serviceEndPoint
     * @param array $attributes
     * @return object
     */
    private function getRequestMock($serviceEndPoint = 'test', $attributes = [])
    {
        $request = $this->prophesize(RequestInterface::class);
        $request->getParams()->willReturn([]);
        $request->getService()->willReturn($serviceEndPoint);
        $request->getAttributes()->willReturn($attributes);

        return $request->reveal();
    }
}
