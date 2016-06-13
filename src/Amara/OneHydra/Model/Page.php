<?php

/*
 * This file is part of the php-onehydra package.
 *
 * (c) Amara Living Ltd
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amara\OneHydra\Model;

/**
 * Page
 *
 * A thin wrapper around a page from OneHydra.
 *
 * @todo How much of this structure is Amara-specific?
 */
class Page implements PageInterface
{
    CONST MAIN_LINKS_SECTION = 'main links';
    CONST RELATED_LINKS_SECTION = 'related links';

    /** @var \stdClass */
    private $rawPage;

    /** @var string */
    private $pageUrl;

    /**
     * @param \stdClass $rawPage
     */
    public function __construct($rawPage)
    {
        $this->rawPage = $rawPage;
    }

    /**
     * @return \stdClass
     */
    public function getRawPage()
    {
        return $this->rawPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadContent()
    {
        return $this->rawPage->HeadContent;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeadContent($headContent)
    {
        $this->rawPage->HeadContent = $headContent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadInstructions()
    {
        return $this->rawPage->HeadInstructions;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeadInstructions($headInstructions)
    {
        $this->rawPage->HeadInstructions = $headInstructions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks()
    {
        return $this->rawPage->Links;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinks($links)
    {
        $this->rawPage->Links = $links;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageContent()
    {
        return $this->rawPage->PageContent;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageContent($pageContent)
    {
        $this->rawPage->PageContent = $pageContent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageUrl($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getServerSide()
    {
        return $this->rawPage->ServerSide;
    }

    /**
     * {@inheritdoc}
     */
    public function setServerSide($serverSide)
    {
        $this->rawPage->ServerSide = $serverSide;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMainLinks()
    {
        return $this->getLinkSection(self::MAIN_LINKS_SECTION);
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedLinks()
    {
        return $this->getLinkSection(self::RELATED_LINKS_SECTION);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkSection($section)
    {
        if (is_array($this->getLinks())) {
            foreach ($this->getLinks() as $link) {
                if ($section === strtolower($link->Key)) {
                    return $link->Value;
                }
            }
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->getHeadContent()->MetaDescription;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeywords()
    {
        return $this->getHeadContent()->MetaKeywords;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getHeadContent()->Title;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectCode()
    {
        return $this->getServerSide()->RedirectCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        return $this->getServerSide()->RedirectTargetUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuggested()
    {
        return ('suggested' === strtolower($this->getServerSide()->PageOrigin));
    }

    /**
     * {@inheritdoc}
     */
    public function getCanonicalUrl()
    {
        return $this->getHeadInstructions()->CanonicalUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getRobots()
    {
        return $this->getHeadInstructions()->MetaRobots;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbstract()
    {
        return $this->getPageContent()->Abstract;
    }

    /**
     * {@inheritdoc}
     */
    public function getH1()
    {
        return $this->getPageContent()->H1;
    }
}