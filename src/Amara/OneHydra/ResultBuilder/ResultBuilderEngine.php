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

/**
 * ResultBuilderEngine
 */
class ResultBuilderEngine implements ResultBuilderEngineInterface
{
    /**
     * @var ResultBuilderInterface[]
     */
    private $builders = [];

    /**
     * @param ResultBuilderInterface[] $builders
     */
    public function __construct($builders = null)
    {
        if (null === $builders) {
            // Use the default, built-in builders
            $builders = [
                new PageResultBuilder(),
                new PagesResultBuilder(),
            ];
        }

        foreach ($builders as $builder) {
            $this->addBuilder($builder);
        }
    }

    /**
     * Add a builder to the list
     *
     * @param ResultBuilderInterface $builder
     */
    public function addBuilder(ResultBuilderInterface $builder)
    {
        $this->builders[$builder->getName()] = $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function build(RequestInterface $request, HttpResponseInterface $httpResponse)
    {
        // Loop over the builders until one of them can build the result
        foreach ($this->builders as $builder) {
            if ($builder->canBuild($request, $httpResponse)) {
                return $builder->build($request, $httpResponse);
            }
        }

        throw new ResultBuilderException("No builder can build the result");
    }
}