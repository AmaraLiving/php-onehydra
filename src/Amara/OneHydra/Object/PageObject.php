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

	CONST MAIN_LINKS_SECTION = 'main links';

	CONST RELATED_LINKS_SECTION = 'related links';

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
	 * @return array
	 */
	public function getServerSide() {
		return $this->serverSide;
	}

	/**
	 * @param mixed $serverSide
	 * @return $this
	 */
	public function setServerSide($serverSide) {
		$this->serverSide = $serverSide;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getMainLinks() {
		return $this->getLinkSection(PageObject::MAIN_LINKS_SECTION);
	}

	/**
	 * @return array
	 */
	public function getRelatedLinks() {
		return $this->getLinkSection(PageObject::RELATED_LINKS_SECTION);
	}

	/**
	 * @param string $section
	 * @return array
	 */
	private function getLinkSection($section) {
		if (is_array($this->links)){
			foreach($this->links as $s) {
				if ($section === strtolower($s->Key)) {
					return $s->Value;
				}
			}
		}

		return [];
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->getHeadContent()->MetaDescription;
	}

	/**
	 * @return string
	 */
	public function getKeywords() {
		return $this->getHeadContent()->MetaKeywords;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->getHeadContent()->Title;
	}

	/**
	 * @return string
	 */
	public function getRedirectCode() {
		return $this->serverSide->RedirectCode;
	}

	/**
	 * @return string
	 */
	public function getRedirectUrl() {
		return $this->serverSide->RedirectTargetUrl;
	}

	/**
	 * @return bool
	 */
	public function isSuggested() {
		return ('suggested' === strtolower($this->serverSide->PageOrigin));
	}

	/**
	 * @return string
	 */
	public function getCanonicalUrl() {
		return $this->headInstructions->CanonicalUrl;
	}

	/**
	 * @return string
	 */
	public function getRobots() {
		return $this->headInstructions->MetaRobots;
	}

	/**
	 * @return string
	 */
	public function getAbstract() {
		return $this->pageContent->Abstract;
	}

	/**
	 * @return string
	 */
	public function getH1() {
		return $this->pageContent->H1;
	}

}