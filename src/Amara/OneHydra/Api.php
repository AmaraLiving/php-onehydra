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

use Amara\OneHydra\Exception\HttpTransportException;
use Amara\OneHydra\Http\HttpRequestBuilderInterface;
use Amara\OneHydra\Http\Transport\TransportInterface;
use Amara\OneHydra\Request\Request;
use Amara\OneHydra\Request\RequestInterface;
use Amara\OneHydra\Result\PageResult;
use Amara\OneHydra\Result\PagesResult;
use Amara\OneHydra\Result\ResultInterface;
use Amara\OneHydra\ResultBuilder\ResultBuilderEngineInterface;

/**
 * OneHydra Api
 */
class Api
{
    // Api version
    const API_VERSION = 'v2';

    // Available Services
    const SERVICE_PAGES = 'pages';
    const SERVICE_PAGE = 'page';

    // Urls
    const URL = 'https://seoapi.onehydra.com';
    const URL_UAT = 'https://uat.seoapi.onehydra.com';

    /**
     * @var HttpRequestBuilderInterface
     */
    private $httpRequestBuilder;

    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * @var ResultBuilderEngineInterface
     */
    private $resultBuilderEngine;

    /**
     * @param HttpRequestBuilderInterface $httpRequestBuilder
     * @param TransportInterface $transport
     * @param ResultBuilderEngineInterface $resultBuilderEngine
     */
    public function __construct(
        HttpRequestBuilderInterface $httpRequestBuilder,
        TransportInterface $transport,
        ResultBuilderEngineInterface $resultBuilderEngine
    ) {
        $this->httpRequestBuilder = $httpRequestBuilder;
        $this->transport = $transport;
        $this->resultBuilderEngine = $resultBuilderEngine;
    }

    /**
     * Get a list of pages
     *
     * @param int|null $count
     * @param \DateTime|null $since
     * @param array $attributes
     * @return PagesResult
     */
    public function getPagesResult($count = null, \DateTime $since = null, $attributes = [])
    {
        $request = new Request();
        $request->setService(self::SERVICE_PAGES);

        if ($since) {
            $request->setParam('since', $since->format('c'));
        }

        if (!is_null($count)) {
            $request->setParam('count', (int)$count);
        }

        $request->setAttributes($attributes);

        return $this->execute($request);
    }

    /**
     * Get details for a page
     *
     * @param string $url
     * @param array $attributes
     * @return PageResult
     */
    public function getPageResult($url, $attributes = [])
    {
        $request = new Request();
        $request->setService(self::SERVICE_PAGE);
        $request->setParam('url', $url);

        $request->setAttributes($attributes);

        return $this->execute($request);
    }

    /**
     * Execute a OneHydra request and return the result
     *
     * @param RequestInterface $request
     * @return ResultInterface
     * @throws HttpTransportException
     */
    public function execute(RequestInterface $request)
    {
        $httpRequest = $this->httpRequestBuilder->build($request);

        $httpResponse = $this->transport->execute($httpRequest);

        return $this->resultBuilderEngine->build($request, $httpResponse);
    }
}