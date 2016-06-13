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

use Amara\OneHydra\Api;
use Amara\OneHydra\Http\HttpResponseInterface;
use Amara\OneHydra\Request\RequestInterface;
use Amara\OneHydra\Result\PagesResult;

class PagesResultBuilder implements ResultBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function canBuild(RequestInterface $request, HttpResponseInterface $response)
    {
        return (Api::SERVICE_PAGES === $request->getService());
    }

    /**
     * {@inheritdoc}
     */
    public function build(RequestInterface $request, HttpResponseInterface $response)
    {
        $json = $response->getBody();
        $data = json_decode($json);

        $rawPageUrls = $data->Pages->PageUrls;

        return new PagesResult($response, $rawPageUrls);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pages';
    }
}