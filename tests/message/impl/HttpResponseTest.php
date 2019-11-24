<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use PHPUnit\Framework\TestCase;

/**
 * Test class for @see HttpResponse class
 * @author Angelis <angelis@users.noreply.github.com>
 */
final class HttpResponseTest extends TestCase
{
  private HttpResponse $httpResponse;

  public function setUp(): void
  {
    $this->httpResponse = new HttpResponse();
  }

  public function testConstruct(): void
  {
    $this->assertNotNull($this->httpResponse);
    $this->assertInstanceOf(HttpResponse::class, $this->httpResponse);
  }

  public function testStatusChanged(): void
  {
    $response = $this->httpResponse
      ->withStatus(200, 'OK');

    $this->assertEquals($response->getStatusCode(), 200);
    $this->assertEquals($response->getReasonPhrase(), 'OK');
  }

  public function testObjectChanged(): void
  {
    $this->assertNotSame($this->httpResponse->withStatus(200, 'OK'), $this->httpResponse);
  }

  public function testToString(): void
  {
    $response = $this->httpResponse
      ->withStatus(200, 'OK');

    $this->assertEquals($response->__toString(), "HTTP/1.1 200 OK\r\n\r\n");
  }
}
