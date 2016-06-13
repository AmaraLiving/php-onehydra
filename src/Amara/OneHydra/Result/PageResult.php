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
use Amara\OneHydra\Model\PageInterface;

/**
 * PageResult
 */
class PageResult implements ResultInterface
{
    /**
     * @var HttpResponseInterface
     */
    private $response;

    /**
     * @var PageInterface
     */
    private $page;

    /**
     * @param HttpResponseInterface $response
     * @param PageInterface $page
     */
    public function __construct(HttpResponseInterface $response, PageInterface $page)
    {
        $this->response = $response;
        $this->page = $page;
    }

    /**
     * @return HttpResponseInterface
     */
    public function getHttpResponse()
    {
        return $this->response;
    }

    /**
     * Get the page object 
     *
     * @return PageInterface
     */
    public function getPage()
    {
        return $this->page;
    }
}