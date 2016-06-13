<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra\Request;

/**
 * RequestInterface
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getService();

    /**
     * @return string[]
     */
    public function getParams();

    /**
     * @return string[]
     */
    public function getAttributes();
}