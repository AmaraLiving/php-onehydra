amara/onehydra
==============

[![Build Status](https://travis-ci.org/AmaraLiving/php-onehydra.svg?branch=master)](https://travis-ci.org/AmaraLiving/php-onehydra)
[![Coverage Status](https://coveralls.io/repos/github/AmaraLiving/php-onehydra/badge.svg?branch=master)](https://coveralls.io/github/AmaraLiving/php-onehydra?branch=master)

Purpose
-------

amara/onehydra is a library for working with the [OneHydra](http://www.onehydra.com/) API from PHP, it's still in 
development so will change often. 

Installation
------------

Use composer:
```
composer require amara/onehydra
```

Example usage
-------------

The library should be extensible for you:

```php
use Amara\OneHydra\Api;
use Amara\OneHydra\Http\HttpRequestBuilder;
use Amara\OneHydra\Http\Transport\GuzzleTransport;
use Amara\OneHydra\ResultBuilder\ResultBuilderEngine;
use GuzzleHttp\Client;

$isUat = false;
$authToken = 'your auth token';

// Use the standard request builder
$httpRequestBuilder = new HttpRequestBuilder($isUat, $authToken);

// Create a Guzzle transport, in UAT you'll need to ignore the OneHydra SSL cert
$guzzleClient = new Client();
$transport = new GuzzleTransport($guzzleClient);

// Create the result builder engine, which will create result objects 
// for our requests
$resultBuilderEngine = new ResultBuilderEngine();

$api = new Api($httpRequestBuilder, $transport, $resultBuilderEngine);
```

Once we have the API, the interface makes it easy to work with:

```php
$pagesResult = $api->getPagesResult();
    
// Print the urls of the pages we will need to fetch details for
foreach ($pagesResult->getPageUrls() as $pageUrl) {
    echo $pageUrl;
}
```

We can then fetch the details for a particular page:

```php
$pageResult = $api->getPageResult('/my/page');
$pageLinks = $pageResult->getPage()->getLinks();
```

Versioning
----------

The library will be following Semantic Versioning, although we don't have a 1.0.0 release
yet!

http://semver.org/spec/v2.0.0.html

