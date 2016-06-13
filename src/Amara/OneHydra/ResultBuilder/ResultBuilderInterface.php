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

/**
 * ResultBuilderInterface
 */
interface ResultBuilderInterface
{
    /**
     * Can we build a result for these?
     *
     * @param RequestInterface $request
     * @param HttpResponseInterface $response
     * @return bool
     */
    public function canBuild(RequestInterface $request, HttpResponseInterface $response);

    /**
     * Build the result
     *
     * @param RequestInterface $request
     * @param HttpResponseInterface $response
     * @throws ResultBuilderException
     * @return ResultInterface
     */
    public function build(RequestInterface $request, HttpResponseInterface $response);

    /**
     * Unique name for the builder
     *
     * @return string
     */
    public function getName();
}