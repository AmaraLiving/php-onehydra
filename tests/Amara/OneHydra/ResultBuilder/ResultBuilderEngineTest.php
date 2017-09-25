<?php

namespace Amara\OneHydra\ResultBuilder;

use Amara\OneHydra\Exception\ResultBuilderException;
use Amara\OneHydra\Http\HttpResponseInterface;
use Amara\OneHydra\Request\RequestInterface;
use PHPUnit_Framework_TestCase;

class ResultBuilderEngineTest extends PHPUnit_Framework_TestCase
{
    public function testAtemptBuildWithoutBuilders ()
    {
        $request = $this->prophesize(RequestInterface::class);
        $httpResponse = $this->prophesize(HttpResponseInterface::class);

        $resultBuilderEngine = new ResultBuilderEngine([]);

        $this->setExpectedException(ResultBuilderException::class);

        $resultBuilderEngine->build($request->reveal(), $httpResponse->reveal());
    }
}
