<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use fall\http\message\StreamInterface;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class StringStream implements StreamInterface
{
  private $content = '';
  private $position = 0;

  public function __construct(string $initialContent)
  {
    $this->write($initialContent);
  }

  public function close(): void
  { }

  public function detach(): ?\resource
  {
    return null;
  }

  public function getSize(): int
  {
    return strlen($this->content);
  }

  public function tell(): int
  {
    return $this->position;
  }

  public function eof(): bool
  {
    return $this->position >= strlen($this->content);
  }

  public function isSeekable(): bool
  {
    return false;
  }

  public function seek(int $offset, int $whence = \SEEK_SET): void
  {
    switch ($whence) {
      case SEEK_SET:
        $this->position = $offset;
        break;

      case SEEK_CUR:
        $this->position += $offset;
        break;

      case SEEK_END:
        $this->position = strlen($this->content) + $offset;
        break;
    }
  }

  public function rewind(): void
  {
    $this->seek(0);
  }

  public function isWritable(): bool
  {
    return true;
  }

  public function write(string $string): int
  {
    $this->content .= $string;
    return strlen($string);
  }

  public function isReadable(): bool
  {
    return true;
  }

  public function read(int $length): string
  {
    $read = substr($this->content, $this->position, $length);
    $this->position += $length;
    return $read;
  }

  public function getContents(): string
  {
    return $this->content;
  }

  public function getMetadata($key = null): ?array
  { }

  public function __toString(): string
  {
    return $this->content;
  }
}
