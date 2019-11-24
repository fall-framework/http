<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use fall\http\message\StreamInterface;
use fall\core\utils\ArrayUtils;
use fall\http\message\MessageInterface;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class HttpMessage implements MessageInterface
{
  protected string $protocolVersion = '1.1';
  protected array $headers = [];
  protected ?StreamInterface $body = null;

  public function getProtocolVersion(): string
  {
    return $this->protocolVersion;
  }

  public function withProtocolVersion(string $protocolVersion): MessageInterface
  {
    $clone = clone $this;
    $clone->protocolVersion = $protocolVersion;
    return $clone;
  }

  public function getHeaders(): array
  {
    $headers = [];
    foreach ($this->headers as $headerKey => $headerObject) {
      $headers[$headerObject->name] = $headerObject->values;
    }
    return $headers;
  }

  public function hasHeader(string $name): bool
  {
    return array_key_exists(strtolower($name), $this->headers);
  }

  public function getHeader(string $name): array
  {
    if (!$this->hasHeader($name)) {
      return [];
    }

    return $this->headers[strtolower($name)]->values;
  }

  public function getHeaderLine(string $name): string
  {
    return implode(',', $this->getHeader($name));
  }

  public function withHeader(string $name, $value): MessageInterface
  {
    if ((!\is_string($value) && !\is_array($value)) || (\is_array($value) && !ArrayUtils::isArrayOfString($value))) {
      throw new \InvalidArgumentException("Value must be a string or a string array. " . $value . " passed");
    }

    $header = new \stdClass();
    $header->name = $name;

    if (\is_array($value)) {
      $header->values = $value;
    } else if (\is_string($value)) {
      $header->values = [$value];
    }

    $clone = clone $this;
    $clone->headers[strtolower($name)] = $header;
    return $clone;
  }

  public function withAddedHeader(string $name, $value): MessageInterface
  {
    if (!$this->hasHeader($name)) {
      return $this->withHeader($name, $value);
    }

    $clone = clone $this;
    $clone->headers[strtolower($name)]->values[] = $value;
    return $clone;
  }

  public function withoutHeader(string $name): MessageInterface
  {
    $clone = clone $this;
    unset($clone->headers[strtolower($name)]);
    return $clone;
  }

  public function getBody(): ?StreamInterface
  {
    return $this->body;
  }

  public function hasBody(): bool
  {
    return $this->body !== null;
  }

  public function withBody(StreamInterface $body)
  {
    $clone = clone $this;
    $clone->body = $body;
    return $clone;
  }
}
