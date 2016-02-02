<?php
/**
 *
 * @author Vincenzo Trapani <vincenzo.trapani@amara.com>
 */
namespace Amara\OneHydra\Object;

interface PageObjectInterface {

	CONST MAIN_LINKS_SECTION = 'main links';

	CONST RELATED_LINKS_SECTION = 'related links';

	/**
	 * @return \stdClass
	 */
	public function getHeadContent();

	/**
	 * @param mixed $headContent
	 * @return $this
	 */
	public function setHeadContent($headContent);

	/**
	 * @return \stdClass
	 */
	public function getHeadInstructions();

	/**
	 * @param mixed $headInstructions
	 * @return $this
	 */
	public function setHeadInstructions($headInstructions);

	/**
	 * @return \stdClass
	 */
	public function getLinks();

	/**
	 * @param mixed $links
	 * @return $this
	 */
	public function setLinks($links);

	/**
	 * @return \stdClass
	 */
	public function getPageContent();

	/**
	 * @param mixed $pageContent
	 * @return $this
	 */
	public function setPageContent($pageContent);

	/**
	 * @return string
	 */
	public function getPageName();

	/**
	 * @param string $pageName
	 * @return $this
	 */
	public function setPageName($pageName);

	/**
	 * @return array
	 */
	public function getServerSide();

	/**
	 * @param mixed $serverSide
	 * @return $this
	 */
	public function setServerSide($serverSide);

	/**
	 * @return array
	 */
	public function getMainLinks();

	/**
	 * @return array
	 */
	public function getRelatedLinks();

	/**
	 * @param string $section
	 * @return array
	 */
	public function getLinkSection($section);

	/**
	 * @return string
	 */
	public function getDescription();

	/**
	 * @return string
	 */
	public function getKeywords();

	/**
	 * @return string
	 */
	public function getTitle();

	/**
	 * @return string
	 */
	public function getRedirectCode();

	/**
	 * @return string
	 */
	public function getRedirectUrl();

	/**
	 * @return bool
	 */
	public function isSuggested();

	/**
	 * @return string
	 */
	public function getCanonicalUrl();

	/**
	 * @return string
	 */
	public function getRobots();

	/**
	 * @return string
	 */
	public function getAbstract();

	/**
	 * @return string
	 */
	public function getH1();
}