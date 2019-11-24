<?php

declare(strict_types=1);

namespace fall\http\client;

use fall\http\message\http\HttpRequest;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class Curl
{
  private $curl;

  private function __construct()
  {
    $this->curl = \curl_init();
  }

  public function __destruct()
  {
    \curl_close($this->curl);
  }

  public function __clone()
  {
    $this->curl = \curl_copy_handle($this->curl);
  }

  public function withOpt(int $option, $value): Curl
  {
    $clone = clone $this;
    \curl_setopt($clone->curl, $option, $value);
    return $clone;
  }

  public function withOpts(array $options = array()): Curl
  {
    $clone = clone $this;
    foreach ($options as $option => $value) {
      \curl_setopt($clone->curl, $option, $value);
    }
    return $clone;
  }

  public function getOpt(int $option)
  {
    return \curl_getinfo($this->curl, $option);
  }

  public function getOpts()
  {
    return \curl_getinfo($this->curl);
  }

  public function withHttpRequest(HttpRequest $httpRequest): Curl
  {
    $customHeaders = [];
    foreach ($httpRequest->getHeaders() as $name => $values) {
      $customHeaders[] = $name . ':' . implode(',', $values);
    }

    $opts = [
      CURLOPT_URL => $httpRequest->getUri()->__toString(),
      CURLOPT_HTTPHEADER => $customHeaders
    ];

    if ($httpRequest->hasHeader('Host') && $httpRequest->hasHeader('Host') != $httpRequest->getUri()->__toString()) {
      $opts[CURLOPT_PROXY] = $httpRequest->getHeaderLine('Host');
    }

    return $this->withOpts($opts);
  }

  public function exec()
  {
    return \curl_exec($this->curl);
  }

  public static function build(): Curl
  {
    return new Curl();
  }
}
