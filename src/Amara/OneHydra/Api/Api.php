<?php
/**
 * Created by PhpStorm.
 * User: vincenzotrapani
 * Date: 06/07/15
 * Time: 17:41
 */
namespace Amara\OneHydra\Api;

use Amara\OneHydra\Http\RequestInterface;
use Amara\OneHydra\Http\Response;
use Amara\OneHydra\Http\ResponseInterface;
use Guzzle\Http\Client;

class Api
{

    // Api version
    const API_VERSION = 'v2';

    // Available Services
    const EP_PAGES = 'pages';
    const EP_PAGE = 'page';

    /** @var array */
    private static $services = [
        Api::EP_PAGE => [
            'method' => 'get',
        ],
        Api::EP_PAGES => [
            'method' => 'get',
        ],
    ];

    /** @var bool * */
    public static $useStaging = false;

    /** @var string */
    private $baseUrl = 'https://seoapi.onehydra.com';

    /** @var string */
    private $baseUrlStaging = 'https://uat.seoapi.onehydra.com';

    /** @var Client */
    private $client;

    /** @var string */
    private $authToken;

    /** @var bool */
    public static $isSecure = true;

    /**
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param Client $client
     * @return $this
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param string $authToken
     * @return $this
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request)
    {
        $serviceUrl = $this->buildServiceUrl($request);

        $method = $request->getMethod();

        if ('get' === $method) {
            $serviceUrl .= '?'.$this->getQueryString($request->getParams());
        }

        $clientRequest = $this->client->$method($serviceUrl, $this->getStandardHeaders());
        $response = $clientRequest->send();

        return (new Response())->setBody($response->getBody(true))->setHeaders($response->getHeaders());
    }

    /**
     * @param array $params
     * @return string
     */
    private function getQueryString($params)
    {
        $query = [];

        foreach ($params as $key => $value) {
            $query[] = $key.'='.$value;
        }

        return implode('&', $query);
    }

    /**
     * @return array
     */
    private function getStandardHeaders()
    {
        return [
            'Authorization' => $this->authToken,
        ];
    }

    /**
     * @param RequestInterface $request
     * @return string
     */
    private function buildServiceUrl(RequestInterface $request)
    {
        return implode(
            '/',
            [(!Api::$useStaging) ? ($this->baseUrl) : ($this->baseUrlStaging), API::API_VERSION, $request->getService()]
        );
    }

    /**
     * @return array
     */
    public static function getServicesList()
    {
        return self::$services;
    }
}