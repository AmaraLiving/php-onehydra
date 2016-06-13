<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra\Result;

use Amara\OneHydra\Http\HttpResponseInterface;

/**
 * PagesResult
 */
class PagesResult implements ResultInterface
{
    /**
     * @var HttpResponseInterface
     */
    private $response;

    /**
     * @var string[]
     */
    private $pageUrls;

    /**
     * @param HttpResponseInterface $response
     * @param string[] $pageUrls
     */
    public function __construct(HttpResponseInterface $response, $pageUrls)
    {
        $this->response = $response;
        $this->pageUrls = $pageUrls;
    }

    /**
     * @return HttpResponseInterface
     */
    public function getHttpResponse()
    {
        return $this->response;
    }

    /**
     * @return string[]
     */
    public function getPageUrls()
    {
        return $this->pageUrls;
    }
}