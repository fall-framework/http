<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use fall\http\message\HttpProtocolVersionEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test class for @see HttpMessage class
 * @author Angelis <angelis@users.noreply.github.com>
 */
final class HttpMessageTest extends TestCase
{
  private HttpMessage $httpMessage;

  public function setUp(): void
  {
    $this->httpMessage = new HttpMessage();
  }

  public function testContruct(): void
  {
    $this->assertInstanceOf(HttpMessage::class, $this->httpMessage);
  }

  public function testProtocolVersionChanged(): void
  {
    $message = $this->httpMessage
      ->withProtocolVersion(HttpProtocolVersionEnum::HTTP_1_1);

    $this->assertEquals($message->getProtocolVersion(), HttpProtocolVersionEnum::HTTP_1_1);
  }

  public function testEmptyProtocolVersion(): void
  {
    $this->assertEquals($this->httpMessage->getProtocolVersion(), HttpProtocolVersionEnum::HTTP_1_1);
  }

  public function testHeaderChanged(): void
  {
    $message = $this->httpMessage
      ->withHeader('Host', 'github.com');

    $this->assertEquals($message->getHeader('Host'), ['github.com']);
    $this->assertEquals($message->getHeaderLine('Host'), 'github.com');
    $this->assertEquals($message->getHeader('HOST'), ['github.com']);
    $this->assertEquals($message->getHeaderLine('HOST'), 'github.com');
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testInvalidHeader(): void
  {
    $message = $this->httpMessage
      ->withHeader('Host', null);

    $this->assertTrue($message->getHeader('Host'), null);
  }

  public function testHeaderAdded(): void
  {
    $message = $this->httpMessage
      ->withHeader('Host', 'github.com')
      ->withAddedHeader('Host', 'travis.org');

    $this->assertEquals($message->getHeader('Host'), ['github.com', 'travis.org']);
    $this->assertEquals($message->getHeaderLine('Host'), 'github.com,travis.org');
    $this->assertEquals($message->getHeader('HOST'), ['github.com', 'travis.org']);
    $this->assertEquals($message->getHeaderLine('HOST'), 'github.com,travis.org');
  }

  public function testHeaderRemoved(): void
  {
    $message = $this->httpMessage
      ->withHeader('Host', 'github.com')
      ->withoutHeader('Host');

    $this->assertEquals($message->getHeader('Host'), []);
    $this->assertEquals($message->getHeaderLine('Host'), '');
    $this->assertEquals($message->getHeader('HOST'), []);
    $this->assertEquals($message->getHeaderLine('HOST'), '');
  }

  public function testEmptyHeader(): void
  {
    $this->assertEquals($this->httpMessage->getHeader('Host'), []);
    $this->assertEquals($this->httpMessage->getHeaderLine('Host'), '');
    $this->assertEquals($this->httpMessage->getHeader('HOST'), []);
    $this->assertEquals($this->httpMessage->getHeaderLine('HOST'), '');
  }

  public function testBodyFilled(): void
  {
    $html = '<!DOCTYPE html><html><head></head><body></body></html>';
    $message = $this->httpMessage
      ->withBody(new StringStream($html));

    $this->assertInstanceOf(StringStream::class, $message->getBody());
    $this->assertEquals($message->getBody()->__toString(), $html);
  }
}
