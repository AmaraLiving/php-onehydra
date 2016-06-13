<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra\Http\Transport;

use Amara\OneHydra\Exception\HttpTransportException;
use Amara\OneHydra\Http\HttpRequestInterface;
use Amara\OneHydra\Http\HttpResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * GuzzleTransport
 */
class GuzzleTransport implements TransportInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(HttpRequestInterface $request)
    {
        $guzzleRequest = $this->guzzleClient->createRequest(
            $request->getMethod(),
            $request->getUrl(),
            [
                'query' => $request->getParams(),
                'headers' => $request->getHeaders(),
            ]
        );

        try {
            $clientResponse = $this->guzzleClient->send($guzzleRequest);
        } catch (RequestException $e) {
            // Re-throw guzzle exception as our own
            throw new HttpTransportException("Guzzle exception", 0, $e);
        }

        return (new HttpResponse())
            ->setBody($clientResponse->getBody())
            ->setHeaders($clientResponse->getHeaders());
    }
}