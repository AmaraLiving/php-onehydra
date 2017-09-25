<?php

namespace Tests\Amara\OneHydra\Request;

use Amara\OneHydra\Request\Request;

/**
 * @coversDefaultClass Amara\OneHydra\Request\Request
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Amara\OneHydra\Request\Request::getService
     * @covers Amara\OneHydra\Request\Request::setService
     */
    public function testGetAndSetService()
    {
        $request = new Request();
        $this->assertNull($request->getService());
        $request->setService('service');
        $this->assertEquals('service', $request->getService());
    }

    /**
     * @covers Amara\OneHydra\Request\Request::getParams
     * @covers Amara\OneHydra\Request\Request::setParams
     * @covers Amara\OneHydra\Request\Request::setParam
     */
    public function testGetAndSetParams()
    {
        $request = new Request();
        $this->assertEmpty($request->getParams());
        $request->setParams([
            'param_key_one' => 'paramOne',
            'param_key_two' => 'paramTwo',
        ]);
        $this->assertEquals(
            [
                'param_key_one' => 'paramOne',
                'param_key_two' => 'paramTwo',
            ],
            $request->getParams()
        );
        $request->setParam('param_key_one', 'alternativeParamOne');
        $this->assertEquals(
            [
                'param_key_one' => 'alternativeParamOne',
                'param_key_two' => 'paramTwo',
            ],
            $request->getParams()
        );
    }

    /**
     * @covers Amara\OneHydra\Request\Request::getAttributes
     * @covers Amara\OneHydra\Request\Request::setAttributes
     * @covers Amara\OneHydra\Request\Request::setAttribute
     */
    public function testGetAndSetAttributes()
    {
        $request = new Request();
        $this->assertEmpty($request->getAttributes());
        $request->setAttributes([
            'attribute_key_one' => 'attributeOne',
            'attribute_key_two' => 'attributeTwo',
        ]);
        $this->assertEquals(
            [
                'attribute_key_one' => 'attributeOne',
                'attribute_key_two' => 'attributeTwo',
            ],
            $request->getAttributes()
        );
        $request->setAttribute('attribute_key_one', 'alternativeAttributeOne');
        $this->assertEquals(
            [
                'attribute_key_one' => 'alternativeAttributeOne',
                'attribute_key_two' => 'attributeTwo',
            ],
            $request->getAttributes()
        );
    }
}