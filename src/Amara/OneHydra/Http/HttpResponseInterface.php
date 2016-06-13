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

/**
 * HttpResponseInterface
 *
 * @todo use PSR7?
 */
interface HttpResponseInterface
{
    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @param array $headers
     */
    public function setHeaders($headers);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $body
     */
    public function setBody($body);
}