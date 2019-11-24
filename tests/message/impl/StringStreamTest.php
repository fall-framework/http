<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use PHPUnit\Framework\TestCase;

/**
 * Test class for @see StringStream class
 * @author Angelis <angelis@users.noreply.github.com>
 */
final class StringStreamTest extends TestCase
{
  const STRING = "something to test";
  private $stringStream;

  public function setUp()
  {
    $this->stringStream = new StringStream(StringStreamTest::STRING);
  }

  public function testSeek()
  {
    $this->stringStream->seek(1);
    $this->assertAttributeEquals(1, 'position', $this->stringStream);

    $this->stringStream->seek(1, SEEK_CUR);
    $this->assertAttributeEquals(2, 'position', $this->stringStream);

    $this->stringStream->seek(1, SEEK_END);
    $this->assertAttributeEquals(strlen(self::STRING) + 1, 'position', $this->stringStream);
  }

  public function testGetContentsSuccess()
  {
    $this->assertEquals($this->stringStream->getContents(), StringStreamTest::STRING);
  }

  public function testReadSuccess()
  {
    $this->assertEquals($this->stringStream->read(1), StringStreamTest::STRING[0]);
    $this->assertEquals($this->stringStream->read(2), substr(StringStreamTest::STRING, 1, 2));
  }
}
