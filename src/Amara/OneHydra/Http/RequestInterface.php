<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 06/07/15
 * Time: 17:31
 */

namespace Amara\OneHydra\Http;

interface RequestInterface
{

    /**
     * @return string
     */
    public function getService();

    /**
     * @param string $service
     */
    public function setService($service);

    /**
     * @return array
     */
    public function getParams();

    /**
     * @param array $params
     */
    public function setParams($params);

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param string $method
     */
    public function setMethod($method);
}