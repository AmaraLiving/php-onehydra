<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 07/07/15
 * Time: 12:16
 */
namespace Amara\OneHydra\Object;

class PageObject {

	/** @var \stdClass */
	private $headContent;

	/** @var \stdClass */
	private $headInstructions;

	/** @var \stdClass */
	private $links;

	/** @var \stdClass */
	private $pageContent;

	/** @var  string */
	private $pageName;

	/** @var \stdClass */
	private $serverSide;

	/**
	 * @return \stdClass
	 */
	public function getHeadContent() {
		return $this->headContent;
	}

	/**
	 * @param mixed $headContent
	 * @return $this
	 */
	public function setHeadContent($headContent) {
		$this->headContent = $headContent;
		return $this;
	}

	/**
	 * @return \stdClass
	 */
	public function getHeadInstructions() {
		return $this->headInstructions;
	}

	/**
	 * @param mixed $headInstructions
	 * @return $this
	 */
	public function setHeadInstructions($headInstructions) {
		$this->headInstructions = $headInstructions;
		return $this;
	}

	/**
	 * @return \stdClass
	 */
	public function getLinks() {
		return $this->links;
	}

	/**
	 * @param mixed $links
	 * @return $this
	 */
	public function setLinks($links) {
		$this->links = $links;
		return $this;
	}

	/**
	 * @return \stdClass
	 */
	public function getPageContent() {
		return $this->pageContent;
	}

	/**
	 * @param mixed $pageContent
	 * @return $this
	 */
	public function setPageContent($pageContent) {
		$this->pageContent = $pageContent;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPageName() {
		return $this->pageName;
	}

	/**
	 * @param string $pageName
	 * @return $this
	 */
	public function setPageName($pageName) {
		$this->pageName = $pageName;

		return $this;
	}

	/**
	 * @param mixed $serverSide
	 * @return $this
	 */
	public function setServerSide($serverSide) {
		$this->serverSide = $serverSide;

		return $this;
	}
}