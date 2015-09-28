<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 24/07/15
 * Time: 16:13
 */
namespace Amara\OneHydra;

use Guzzle\Http\Client;
use Pimple\Container as C;


class Container {

	/**
	 * @var \Pimple\Container
	 */
	private static $container;

	/**
	 * @var Container
	 */
	private static $instance = null;

	/**
	 * Use the static method getContainer()
	 * to get the configured container
	 */
	private function __construct() {
		// Pimple container
		self::$container = new C;

		self::$container['request_builder'] = function () {
			return new Http\RequestBuilder();
		};

		self::$container['page_object'] = self::$container->factory(function () {
			return new Object\PageObject();
		});

		self::$container['request'] = self::$container->factory(function () {
			return new Http\Request();
		});

		self::$container['page_object_factory'] = function () {
			return new Factory\PageObjectFactory();
		};

		self::$container['object_factory'] = function ($c) {
			return (new Factory\ObjectFactory())->setPageObjectFactory($c['page_object_factory']);
		};

		self::$container['client'] = function () {
			$client = new Client();

			if (!Api::$isSecure) {
				$client->setDefaultOption('verify', false);
			}
	
			return $client;
		};

		self::$container['api'] = function ($c) {
			return (new Api\Api())->setClient($c['client']);
		};
	}

	/**
	 * Return the configured container
	 *
	 * @return \Pimple\Container
	 */
	public static function getContainer() {
		if (is_null(self::$instance)) {
			self::$instance = new self;
		}

		return self::$container;
	}
}