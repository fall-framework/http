<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use fall\http\message\HttpMethodEnum;
use fall\http\message\RequestInterface;
use fall\http\message\UriInterface;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class HttpRequest extends HttpMessage implements RequestInterface
{
  private ?string $requestTarget = null;
  private ?string $method = null;
  private ?UriInterface $uri = null;

  public function getRequestTarget(): string
  {
    return ($this->requestTarget !== null) ? $this->requestTarget : '/';
  }

  public function withRequestTarget(string $requestTarget): RequestInterface
  {
    $clone = clone $this;
    $clone->requestTarget = $requestTarget;
    return $clone;
  }

  public function getMethod(): string
  {
    return $this->method;
  }

  public function withMethod(string $method): RequestInterface
  {
    $reflectionClass = new \ReflectionClass(HttpMethodEnum::class);
    if ($reflectionClass->getConstant($method) === false) {
      throw new \InvalidArgumentException("Method " . $method . " doesn't exists !");
    }

    $clone = clone $this;
    $clone->method = $method;
    return $clone;
  }

  public function getUri(): UriInterface
  {
    return $this->uri;
  }

  public function withUri(UriInterface $uri, $preserveHost = false): RequestInterface
  {
    $clone = clone $this;
    $clone->uri = $uri;

    if ($uri->getHost() !== '') {
      if (!$preserveHost || ($preserveHost && !$this->hasHeader('Host'))) {
        $clone = $clone->withHeader('Host', $uri->getHost());
      }
    }

    return $clone;
  }

  public function __toString()
  {
    $string = '';
    $string .= $this->method . ' ' . $this->requestTarget . ' HTTP/' . $this->protocolVersion . "\r\n";
    foreach ($this->getHeaders() as $headerName => $headerValues) {
      $string .= $headerName . ': ' . implode(', ', $headerValues) . "\r\n";
    }
    $string .= "\r\n";
    if ($this->hasBody()) {
      $string .= $this->getBody();
    }
    return $string;
  }
}
