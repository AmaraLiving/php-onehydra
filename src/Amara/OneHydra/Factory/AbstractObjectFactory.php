<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 07/07/15
 * Time: 13:51
 */

namespace Amara\OneHydra\Factory;

use Amara\OneHydra\Http\ResponseInterface;

abstract class AbstractObjectFactory {

	abstract public function createFromResponse(ResponseInterface $response, $options);
}