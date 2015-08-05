<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 06/07/15
 * Time: 17:32
 */
namespace Amara\OneHydra\Http;

interface ResponseInterface {

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