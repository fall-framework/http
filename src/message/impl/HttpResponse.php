<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use fall\http\message\ResponseInterface;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class HttpResponse extends HttpMessage implements ResponseInterface
{
  private int $statusCode;
  private string $reasonPhrase;

  public function getStatusCode(): int
  {
    return $this->statusCode;
  }

  public function withStatus(int $statusCode, string $reasonPhrase = ''): ResponseInterface
  {
    $clone = clone $this;
    $clone->statusCode = $statusCode;
    $clone->reasonPhrase = $reasonPhrase;
    return $clone;
  }

  public function getReasonPhrase(): string
  {
    return $this->reasonPhrase !== null ? $this->reasonPhrase : '';
  }

  public function __toString()
  {
    $string = 'HTTP/' . $this->protocolVersion . ' ' . $this->getStatusCode() . ' ' . $this->getReasonPhrase() . "\r\n";
    foreach ($this->getHeaders() as $name => $value) {
      $string .= $name . ': ' . implode(',', $value) . "\r\n";
    }
    $string .= "\r\n";
    if ($this->hasBody()) {
      $string .= $this->getBody();
    }

    return $string;
  }
}
