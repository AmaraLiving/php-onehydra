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
use Amara\OneHydra\Exception\ResultBuilderException;
use Amara\OneHydra\Http\HttpResponseInterface;
use Amara\OneHydra\Model\Page;
use Amara\OneHydra\Request\RequestInterface;
use Amara\OneHydra\Result\PageResult;

/**
 * PageResultBuilder
 */
class PageResultBuilder implements ResultBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function canBuild(RequestInterface $request, HttpResponseInterface $response)
    {
        return (Api::SERVICE_PAGE === $request->getService());
    }

    /**
     * {@inheritdoc}
     */
    public function build(RequestInterface $request, HttpResponseInterface $response)
    {
        $url = $request->getParams()['url'];

        $json = $response->getBody();

        $data = json_decode($json);

        if (!isset($data->Page)) {
            throw new ResultBuilderException("Required element was not present in response (Page)");
        }

        $rawPage = $data->Page;

        $requiredProperties = [
            "HeadContent",
            "HeadInstructions",
            "Links",
            "PageContent",
            "ServerSide",
        ];

        foreach ($requiredProperties as $expectedProperty) {
            if (!isset($rawPage->{$expectedProperty})) {
                throw new ResultBuilderException(
                    "Required element was not present in response (Page.{$expectedProperty})"
                );
            }
        }

        $page = new Page($rawPage);
        $page->setPageUrl($url);

        return new PageResult($response, $page);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'page';
    }
}