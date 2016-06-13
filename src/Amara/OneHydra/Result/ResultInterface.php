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
 * ResultInterface
 *
 * The result of a call to the OneHydra API
 */
interface ResultInterface
{
    /**
     * Get the HttpResponse that the result was created for
     *
     * @return HttpResponseInterface
     */
    public function getHttpResponse();
}