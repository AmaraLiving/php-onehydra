<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 07/07/15
 * Time: 09:42
 */
namespace Amara\OneHydra\Factory;

use Amara\OneHydra\Http\ResponseInterface;
use Amara\OneHydra\Object\PageObject;


class ObjectFactory
{

    /** @var PageObjectFactory */
    private $pageObjectFactory;

    /**
     * @param PageObjectFactory $pageObjectFactory
     * @return $this
     */
    public function setPageObjectFactory(PageObjectFactory $pageObjectFactory)
    {
        $this->pageObjectFactory = $pageObjectFactory;

        return $this;
    }

    /**
     * @param ResponseInterface $response
     * @param string $type
     * @param array $options
     * @return PageObject
     */
    public function makeFromResponse(ResponseInterface $response, $type, $options = [])
    {
        switch (strtolower($type)) {
            case 'page':
                return $this->pageObjectFactory->createFromResponse($response, $options);
                break;
        }
    }
}