<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra\Http;

use Amara\OneHydra\Api;
use Amara\OneHydra\Request\RequestInterface;

/**
 * HttpRequestBuilder
 */
class HttpRequestBuilder implements HttpRequestBuilderInterface
{
    /**
     * The current base url for the requests
     *
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $authToken;

    /**
     * @param bool $isUat
     * @param string $authToken
     */
    public function __construct($isUat, $authToken)
    {
        $this->baseUrl = Api::URL;
        if ($isUat) {
            $this->baseUrl = Api::URL_UAT;
        }

        $this->authToken = $authToken;
    }

    /**
     * {@inheritdoc}
     */
    public function build(RequestInterface $request)
    {
        $httpRequest = new HttpRequest();
        $httpRequest->setMethod('get');
        $httpRequest->setParams($this->buildParams($request));
        $httpRequest->setUrl($this->buildServiceUrl($request));
        $httpRequest->setHeaders($this->buildHeaders($request));

        return $httpRequest;
    }

    /**
     * @param RequestInterface $request
     * @return string
     */
    protected function buildServiceUrl(RequestInterface $request)
    {
        $serviceUrl = implode(
            '/',
            [
                $this->baseUrl,
                Api::API_VERSION,
                $request->getService(),
            ]
        );

        return $serviceUrl;
    }

    /**
     * @param RequestInterface $request
     * @return string[]
     */
    protected function buildHeaders(RequestInterface $request)
    {
        // If the auth token has been provided as an attribute of the
        // request then we use it
        $authToken = $this->authToken;
        if (isset($request->getAttributes()['auth_token'])) {
            $authToken = $request->getAttributes()['auth_token'];
        }

        return ['Authorization' => $authToken];
    }

    /**
     * @param RequestInterface $request
     * @return string[]
     */
    protected function buildParams(RequestInterface $request)
    {
        return $request->getParams();
    }
}