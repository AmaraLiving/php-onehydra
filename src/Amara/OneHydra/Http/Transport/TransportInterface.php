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
use Amara\OneHydra\Http\HttpResponseInterface;

/**
 * TransportInterface
 */
interface TransportInterface
{
    /**
     * @param HttpRequestInterface $request
     * @return HttpResponseInterface
     * @throws HttpTransportException
     */
    public function execute(HttpRequestInterface $request);
}