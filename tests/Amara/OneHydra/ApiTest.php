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

use Amara\OneHydra\Http\HttpRequestBuilderInterface;
use Amara\OneHydra\Http\HttpRequestInterface;
use Amara\OneHydra\Http\HttpResponseInterface;
use Amara\OneHydra\Http\Transport\TransportInterface;
use Amara\OneHydra\Request\RequestInterface;
use Amara\OneHydra\Result\ResultInterface;
use Amara\OneHydra\ResultBuilder\ResultBuilderEngineInterface;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

class ApiTest extends PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $httpRequestBuilder = $this->prophesize(HttpRequestBuilderInterface::class);
        $transport = $this->prophesize(TransportInterface::class);
        $resultBuilderEngine = $this->prophesize(ResultBuilderEngineInterface::class);

        $request = $this->prophesize(RequestInterface::class);
        $result = $this->prophesize(ResultInterface::class);
        $httpRequest = $this->prophesize(HttpRequestInterface::class);
        $httpResponse = $this->prophesize(HttpResponseInterface::class);

        $httpRequestBuilder->build($request)->willReturn($httpRequest);
        $transport->execute($httpRequest)->willReturn($httpResponse);
        $resultBuilderEngine->build($request, $httpResponse)->willReturn($result);

        $api = new Api($httpRequestBuilder->reveal(), $transport->reveal(), $resultBuilderEngine->reveal());

        $actualResult = $api->execute($request->reveal());

        $this->assertEquals($result->reveal(), $actualResult);
    }

    /**
     * @dataProvider provideGetPagesResult
     */
    public function testGetPagesResult($since, $count, $expectedParams)
    {
        $attributes = ['something' => '1'];

        $requestMatcher = Argument::that(
            function ($request) use ($since, $count, $attributes, $expectedParams) {
                return (
                    $request instanceof RequestInterface &&
                    'pages' === $request->getService() &&
                    $expectedParams == $request->getParams() &&
                    $attributes === $request->getAttributes()
                );
            }
        );

        $httpRequestBuilder = $this->prophesize(HttpRequestBuilderInterface::class);
        $transport = $this->prophesize(TransportInterface::class);
        $resultBuilderEngine = $this->prophesize(ResultBuilderEngineInterface::class);

        $result = $this->prophesize(ResultInterface::class);
        $httpRequest = $this->prophesize(HttpRequestInterface::class);
        $httpResponse = $this->prophesize(HttpResponseInterface::class);

        $httpRequestBuilder->build($requestMatcher)->willReturn($httpRequest);
        $transport->execute($httpRequest)->willReturn($httpResponse);
        $resultBuilderEngine->build($requestMatcher, $httpResponse)->willReturn($result);

        $api = new Api($httpRequestBuilder->reveal(), $transport->reveal(), $resultBuilderEngine->reveal());

        $actualResult = $api->getPagesResult($count, $since, $attributes);

        $this->assertEquals($result->reveal(), $actualResult);
    }

    public function provideGetPagesResult()
    {
        return [
            [
                $since = null,
                $count = null,
                $expectedParams = [],
            ],
            [
                $since = new \DateTime('2016-05-28 13:33:47+00:00'),
                $count = 4,
                $expectedParams = [
                    'since' => '2016-05-28T13:33:47+00:00',
                    'count' => 4,
                ],
            ],
        ];
    }

    public function testGetPageResult()
    {
        $url = '/foo';
        $attributes = ['something' => '1'];

        $requestMatcher = Argument::that(
            function ($request) use ($url, $attributes) {
                return (
                    $request instanceof RequestInterface &&
                    'page' === $request->getService() &&
                    $url === $request->getParams()['url'] &&
                    $attributes === $request->getAttributes()
                );
            }
        );

        $httpRequestBuilder = $this->prophesize(HttpRequestBuilderInterface::class);
        $transport = $this->prophesize(TransportInterface::class);
        $resultBuilderEngine = $this->prophesize(ResultBuilderEngineInterface::class);

        $result = $this->prophesize(ResultInterface::class);
        $httpRequest = $this->prophesize(HttpRequestInterface::class);
        $httpResponse = $this->prophesize(HttpResponseInterface::class);

        $httpRequestBuilder->build($requestMatcher)->willReturn($httpRequest);
        $transport->execute($httpRequest)->willReturn($httpResponse);
        $resultBuilderEngine->build($requestMatcher, $httpResponse)->willReturn($result);

        $api = new Api($httpRequestBuilder->reveal(), $transport->reveal(), $resultBuilderEngine->reveal());

        $actualResult = $api->getPageResult($url, $attributes);

        $this->assertEquals($result->reveal(), $actualResult);
    }
}