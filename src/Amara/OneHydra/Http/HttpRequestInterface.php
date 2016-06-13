<?php
namespace Amara\OneHydra\Http;

/**
 * HttpRequestInterface
 *
 * @todo use PSR7?
 */
interface HttpRequestInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string[]
     */
    public function getParams();

    /**
     * @return string[]
     */
    public function getHeaders();
}