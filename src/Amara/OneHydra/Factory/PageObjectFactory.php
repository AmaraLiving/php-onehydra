<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 07/07/15
 * Time: 12:18
 */

namespace Amara\OneHydra\Factory;

use Amara\OneHydra\Container;
use Amara\OneHydra\Object\PageObjec;
use Amara\OneHydra\Object\PageObject;
use Amara\OneHydra\Http\ResponseInterface;

class PageObjectFactory extends AbstractObjectFactory {


	/**
	 * @return \Pimple\Container
	 */
	public function getContainer() {
		return Container::getContainer();
	}

	/**
	 * @param ResponseInterface $response
	 * @param array $options
	 * @return PageObject
	 */
	public function createFromResponse(ResponseInterface $response, $options) {
		$data = $response->getBody();
		$page = $data->Page;

		$container = $this->getContainer();

		/** @var PageObject $pageObject */
		$pageObject = $container['page_object'];
		$pageObject->setHeadContent($page->HeadContent)
			->setHeadInstructions($page->HeadInstructions)
			->setLinks($page->Links)
			->setPageName($options['pageName'])
			->setPageContent($page->PageContent)
			->setServerSide($page->ServerSide);

		return $pageObject;
	}

}