<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 06/07/15
 * Time: 17:36
 */
namespace Amara\OneHydra\Http;

use Amara\OneHydra\Api\Api;
use Amara\OneHydra\Exception\InvalidServiceException;
use Amara\OneHydra\Exception\NotAllowedHttpVerbException;
use Amara\OneHydra\Exception\WrongTypeException;

class RequestBuilder {

	/** @var string */
	private $service;

	/** @var string */
	private $method;

	/** @var array */
	private $params = [];

	/** @var array */
	private $allowedVerbs = ['get'];

	/**
	 * @param string $service
	 * @return $this
	 * @throws InvalidServiceException
	 * @throws NotAllowedHttpVerbException
	 */
	public function setService($service) {
		$services = Api::getServicesList();


		if (!array_key_exists($service, $services)) {
			throw new InvalidServiceException('Invalid service ' . $service);
		}

		$this->method = strtolower($services[$service]['method']);

		if (!in_array($this->method, $this->allowedVerbs)) {
			throw new NotAllowedHttpVerbException();
		}

		$this->service = $service;

		return $this;
	}


	/**
	 * @param array $params
	 * @return $this
	 * @throws WrongTypeException
	 */
	public function setParams($params) {

		if (is_null($params) || !is_array($params)) {
			throw new WrongTypeException('Invalid "$params" type');
		}

		$this->params = $params;

		return $this;
	}


	/**
	 * @param bool $clean optional
	 * @return Request
	 */
	public function build($clean = true) {
		$request = (new Request())->setService($this->service)
			->setMethod($this->method)
			->setParams($this->params);

		if ($clean) {
			$this->service = '';
			$this->method = '';
			$this->params = [];
		}

		return $request;
	}


}