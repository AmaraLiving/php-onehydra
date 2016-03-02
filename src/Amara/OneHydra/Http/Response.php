<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 07/07/15
 * Time: 10:47
 */

namespace Amara\OneHydra\Http;


class Response implements ResponseInterface
{

    /** @var array */
    private $headers;

    /** @var string */
    private $body;

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        // TODO check the content-type
        $this->body = \json_decode($body);

        return $this;
    }
}