<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra\ResultBuilder;

use Amara\OneHydra\Exception\ResultBuilderException;
use Amara\OneHydra\Http\HttpResponseInterface;
use Amara\OneHydra\Request\RequestInterface;
use Amara\OneHydra\Result\ResultInterface;

interface ResultBuilderEngineInterface
{
    /**
     * Build a OneHydra result from the OneHydra request and HTTP response
     *
     * @param RequestInterface $request
     * @param HttpResponseInterface $httpResponse
     * @return ResultInterface
     * @throws ResultBuilderException
     */
    public function build(RequestInterface $request, HttpResponseInterface $httpResponse);
}