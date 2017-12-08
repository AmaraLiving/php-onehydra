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

use Amara\OneHydra\Exception\HttpTransportException;
use Amara\OneHydra\Http\HttpRequestInterface;
use Amara\OneHydra\Http\Transport\GuzzleTransport;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Prophecy\Argument;
use Psr\Http\Message\MessageInterface;

/**
 * GuzzleTransportTest
 *
 * @coversDefaultClass Amara\OneHydra\Http\Transport
 */
class GuzzleTransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Amara\OneHydra\Http\Transport\GuzzleTransport::__construct
     * @covers Amara\OneHydra\Http\Transport\GuzzleTransport::execute
     */
    public function testExecuteWhenOkay()
    {
        $method = 'GET';
        $url = '/foo';
        $params = ['oh' => 'hai'];
        $headers = ['oh' => ['really']];

        $responseBody = '{}';
        $responseHeaders = ['went' => 'great'];

        $request = $this->getRequestMock($url, $params, $headers, $method);

        $guzzleResponse = $this->prophesize(MessageInterface::class);
        $guzzleResponse->getBody()->willReturn($responseBody);
        $guzzleResponse->getHeaders()->willReturn($responseHeaders);

        $guzzleClient = $this->prophesize(Client::class);
        $guzzleClient->send(
            Argument::that(
                function (Request $request) use ($method, $url, $headers) {
                    $this->assertEquals($method, $request->getMethod());
                    $this->assertEquals($url, $request->getUri());
                    $this->assertEquals(
                        $headers,
                        $request->getHeaders()
                    );

                    return true;
                }
            ), ['query' => $params]
        )->willReturn($guzzleResponse);

        $guzzleTransport = new GuzzleTransport($guzzleClient->reveal());
        $httpResponse = $guzzleTransport->execute($request);

        $this->assertEquals($responseHeaders, $httpResponse->getHeaders());
        $this->assertEquals($responseBody, $httpResponse->getBody());
    }

    /**
     * @covers Amara\OneHydra\Http\Transport\GuzzleTransport::__construct
     * @covers Amara\OneHydra\Http\Transport\GuzzleTransport::execute
     */
    public function testExecuteWhenGuzzleThrowsException()
    {
        $method = 'get';
        $url = '/foo';
        $params = ['oh' => 'hai'];
        $headers = ['oh' => 'really'];

        $this->setExpectedException(HttpTransportException::class);

        $request = $this->getRequestMock($url, $params, $headers, $method);
        $guzzleClient = $this->prophesize(Client::class);
        $guzzleClient->send(Argument::type(Request::class), ['query' => $params])->willThrow(
            RequestException::class
        );

        $guzzleTransport = new GuzzleTransport($guzzleClient->reveal());
        $guzzleTransport->execute($request);
    }

    /**
     * Gets a Request Mock
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param string $method
     *
     * @return HttpRequestInterface
     */
    private function getRequestMock($url = '/foo', $params = [], $headers = [], $method = 'get')
    {
        $request = $this->prophesize(HttpRequestInterface::class);
        $request->getMethod()->willReturn($method);
        $request->getUrl()->willReturn($url);
        $request->getParams()->willReturn($params);
        $request->getHeaders()->willReturn($headers);

        return $request->reveal();
    }
}