<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use fall\http\message\UriInterface;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class Uri implements UriInterface
{
  private ?string $scheme = null;
  private ?string $user = null;
  private ?string $password = null;
  private ?string $host = null;
  private ?int $port = null;
  private ?string $path = null;
  private ?string $query = null;
  private ?string $fragment = null;

  public function getScheme(): string
  {
    return $this->scheme !== null ? $this->scheme : '';
  }

  public function withScheme(string $scheme): UriInterface
  {
    $clone = clone $this;
    $clone->scheme = $scheme;
    return $clone;
  }

  public function getAuthority(): string
  {
    if ($this->user === null) {
      return '';
    }
    return $this->getUserInfo() . '@' . $this->getHost() . ($this->port !== null && $this->port !== 80 ? ':' . $this->port : '');
  }

  public function getUserInfo(): string
  {
    if ($this->user === null) {
      return '';
    }

    return $this->user . ($this->password != null ? ':' . $this->password : '');
  }

  public function withUserInfo(string $user, string $password = null): UriInterface
  {
    $clone = clone $this;
    $clone->user = $user;
    $clone->password = $password;
    return $clone;
  }

  public function getHost(): string
  {
    return $this->host !== null ? strtolower($this->host) : '';
  }

  public function withHost(string $host): UriInterface
  {
    $clone = clone $this;
    $clone->host = $host;
    return $clone;
  }

  public function getPort(): int
  {
    return $this->host !== null ? $this->host : '';
  }

  public function withPort(int $port): UriInterface
  {
    $clone = clone $this;
    $clone->port = $port;
    return $clone;
  }

  public function getPath(): string
  {
    return $this->path;
  }

  public function withPath(string $path): UriInterface
  {
    $clone = clone $this;
    $clone->path = $path;
    return $clone;
  }

  public function getQuery(): string
  {
    return $this->query !== null ? $this->query : '';
  }

  public function withQuery(string $query): UriInterface
  {
    $clone = clone $this;
    $clone->query = $query;
    return $clone;
  }

  public function getFragment(): string
  {
    return $this->fragment !== null ? $this->fragment : '';
  }

  public function withFragment(string $fragment): UriInterface
  {
    $clone = clone $this;
    $clone->fragment = $fragment;
    return $clone;
  }

  public function __toString(): string
  {
    $string = $this->getScheme() . ($this->scheme != null ? ':' : '');
    if ($this->user !== null) {
      $string .= '//' . $this->getAuthority();
    } else {
      $string .= '//' . $this->getHost();
    }

    $string .= ($this->path[0] !== '/' ? '/' : '') . $this->getPath();
    $string .= ($this->query !== null  ? '?' : '') . $this->getQuery();
    $string .= ($this->fragment !== null  ? '#' : '') . $this->getFragment();

    return $string;
  }
}
