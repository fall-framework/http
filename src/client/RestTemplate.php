<?php
declare(strict_types=1);


namespace fall\http\client;

use fall\http\message\HttpMethodEnum;
use fall\http\message\http\HttpRequest;
use fall\http\message\http\Uri;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class RestTemplate implements RestOperations
{
  private $clientHttpRequestFactory;
  private $clientCurlFactory;

  public function __construct(ClientHttpRequestFactory $clientHttpRequestFactory = null)
  {
    if ($clientHttpRequestFactory === null) {
      $clientHttpRequestFactory = new class implements ClientHttpRequestFactory
      {
        public function createRequest(Uri $uri): HttpRequest
        {
          return (new HttpRequest())
            ->withUri($uri);
        }
      };
    }

    $this->setClientHttpRequestFactory($clientHttpRequestFactory);
  }

  public function setClientHttpRequestFactory(ClientHttpRequestFactory $clientHttpRequestFactory)
  {
    $this->clientHttpRequestFactory = $clientHttpRequestFactory;
  }

  public function setClientCurlFactory(ClientCurlFactory $clientCurlFactory)
  {
    $this->clientCurlFactory = $clientCurlFactory;
  }

  public function getForObject(string $url, $responseType, array $uriVariables = [])
  {
    $urlComponents = \parse_url($url);
    if (!isset($urlComponents['port'])) {
      $urlComponents['port'] = 80;
    }

    if (!isset($urlComponents['path'])) {
      $urlComponents['path'] = '/';
    }

    if (!isset($urlComponents['query'])) {
      $urlComponents['query'] = '';
    }

    $uri = (new Uri())
      ->withScheme($urlComponents['scheme'])
      ->withHost($urlComponents['host'])
      ->withPort($urlComponents['port'])
      ->withPath($urlComponents['path'])
      ->withQuery($urlComponents['query']);

    $httpRequest = $this->clientHttpRequestFactory->createRequest($uri)
      ->withMethod(HttpMethodEnum::GET);

    $opts = array(
      CURLOPT_RETURNTRANSFER => true
    );

    $response = $this->clientCurlFactory->createCurl($opts)
      ->withHttpRequest($httpRequest)
      ->exec();

    return json_decode($response);
  }
}
