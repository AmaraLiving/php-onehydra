<?php
namespace Amara\OneHydra\Model;


/**
 * PageInterface
 *
 * This interface is not stable yet:
 *
 * @todo How much of this structure is Amara-specific?
 * @todo Remove setters and make this immutable?
 */
interface PageInterface
{
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
     * @param \stdClass $headInstructions
     * @return $this
     */
    public function setHeadInstructions($headInstructions);

    /**
     * @return \stdClass
     */
    public function getLinks();

    /**
     * @param \stdClass $links
     * @return $this
     */
    public function setLinks($links);

    /**
     * @return \stdClass
     */
    public function getPageContent();

    /**
     * @param \stdClass $pageContent
     * @return $this
     */
    public function setPageContent($pageContent);

    /**
     * @return string
     */
    public function getPageUrl();

    /**
     * @param string $pageUrl
     * @return $this
     */
    public function setPageUrl($pageUrl);

    /**
     * @return \stdClass
     */
    public function getServerSide();

    /**
     * @param \stdClass $serverSide
     * @return $this
     */
    public function setServerSide($serverSide);

    /**
     * @deprecated Remove this as it's likely to be Amara-specific
     * @return array
     */
    public function getMainLinks();

    /**
     * @deprecated Remove this as it's likely to be Amara-specific
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