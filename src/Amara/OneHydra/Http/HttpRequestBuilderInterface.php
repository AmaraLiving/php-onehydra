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

use Amara\OneHydra\Request\RequestInterface;

/**
 * HttpRequestBuilderInterface
 */
interface HttpRequestBuilderInterface
{
    /**
     * Build an HTTP request for the OneHydra request
     *
     * @param RequestInterface $request
     * @return HttpRequestInterface
     */
    public function build(RequestInterface $request);
}