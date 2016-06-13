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
use GuzzleHttp\Message\MessageInterface;
use GuzzleHttp\Message\Request as GuzzleRequest;

/**
 * Class GuzzleTransportTest
 *
 * @package Amara\OneHydra\Http\Transport
 * @coversDefaultClass Amara\OneHydra\Http\Transport
 */
class GuzzleTransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Amara\OneHydra\Http\Transport\GuzzleTransport::execute
     */
    public function testExecuteWhenOkay()
    {
        $method = 'get';
        $url = '/foo';
        $params = ['oh' => 'hai'];
        $headers = ['oh' => 'really'];

        $responseBody = '{}';
        $responseHeaders = ['went' => 'great'];

        $request = $this->getRequestMock($url, $params, $headers, $method);
        $guzzleRequest = $this->prophesize(GuzzleRequest::class);

        $guzzleResponse = $this->prophesize(MessageInterface::class);
        $guzzleResponse->getBody()->willReturn($responseBody);
        $guzzleResponse->getHeaders()->willReturn($responseHeaders);

        $guzzleClient = $this->prophesize(Client::class);
        $guzzleClient->createRequest(
            $method,
            $url,
            [
                'query' => $params,
                'headers' => $headers
            ]
        )->willReturn($guzzleRequest);
        $guzzleClient->send($guzzleRequest)->willReturn($guzzleResponse);

        $guzzleTransport = new GuzzleTransport($guzzleClient->reveal());
        $httpResponse = $guzzleTransport->execute($request);

        $this->assertEquals($responseHeaders, $httpResponse->getHeaders());
        $this->assertEquals($responseBody, $httpResponse->getBody());
    }

    /**
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
        $guzzleClient = $this->getGuzzleClientMock(RequestException::class, $url, $params, $headers, $method);

        $guzzleTransport = new GuzzleTransport($guzzleClient);
        $guzzleTransport->execute($request);
    }

    /**
     * Gets a Request Mock
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param string $method
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

    /**
     * Gets a guzzle request Mock
     *
     * @param mixed $response
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return Client
     */
    private function getGuzzleClientMock($response, $url = '/foo', $params = [], $headers = [], $method = 'get')
    {
        $guzzleRequest = $this->prophesize(GuzzleRequest::class);
        
        $guzzleClient = $this->prophesize(Client::class);
        $guzzleClient
            ->createRequest($method, $url, [
                'query' => $params,
                'headers' => $headers
            ])
            ->willReturn($guzzleRequest);
        $guzzleClient->send($guzzleRequest)->willThrow($response);

        return $guzzleClient->reveal();
    }

}