<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use ffall\http\message\StreamInterface;
use fall\core\net\Socket;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
class SocketStream implements StreamInterface
{
  private $socket;
  private $contents;

  public function __construct(Socket $socket)
  {
    $this->socket = $socket;
  }

  public function close()
  {
    $this->socket->close();
  }

  public function detach()
  { }
  public function getSize()
  { }
  public function tell()
  { }

  public function eof()
  { }

  public function isSeekable(): bool
  {
    return false;
  }

  public function seek($offset, $whence = SEEK_SET)
  { }

  public function rewind()
  { }

  public function isWritable(): bool
  {
    return true;
  }

  public function write(string $string): int
  {
    return $this->socket->write($string);
  }

  public function isReadable(): bool
  {
    return true;
  }

  public function read($length)
  {
    return $this->socket->read($length);
  }

  public function getContents(): string
  {
    return $this->contents;
  }

  public function getMetadata($key = null)
  { }

  public function __toString(): string
  {
    return $this->getContents();
  }
}
