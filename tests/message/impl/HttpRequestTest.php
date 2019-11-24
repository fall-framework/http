<?php

declare(strict_types=1);

namespace fall\http\message\impl;

use fall\http\message\HttpMethodEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test class for {@see HttpRequest} class
 * @author Angelis <angelis@users.noreply.github.com>
 */
final class HttpRequestTest extends TestCase
{
  private HttpRequest $httpRequest;

  public function setUp(): void
  {
    $this->httpRequest = new HttpRequest();
  }

  public function testConstruct(): void
  {
    $this->assertNotNull($this->httpRequest);
    $this->assertInstanceOf(HttpRequest::class, $this->httpRequest);
  }

  public function testRequestTargetChanged(): void
  {
    $request = $this->httpRequest
      ->withRequestTarget('/test');

    $this->assertEquals($request->getRequestTarget(), '/test');
  }

  public function testEmptyRequestTarget(): void
  {
    $this->assertEquals($this->httpRequest->getRequestTarget(), '/');
  }

  public function testMethodChanged(): void
  {
    $request = (new HttpRequest())
      ->withMethod(HttpMethodEnum::GET);

    $this->assertEquals($request->getMethod(), HttpMethodEnum::GET);
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testMethodInvalid(): void
  {
    (new HttpRequest())
      ->withMethod('test');
  }

  public function testUriChanged(): void
  {
    $uri = (new Uri());

    $request = (new HttpRequest())
      ->withUri($uri);

    $this->assertSame($request->getUri(), $uri);
  }

  public function testObjectChanged(): void
  {
    $request = new HttpRequest();

    $this->assertNotSame($request->withRequestTarget('/test'), $request);
    $this->assertNotSame($request->withMethod(HttpMethodEnum::GET), $request);
    $this->assertNotSame($request->withUri(new Uri()), $request);
  }

  public function testToString(): void
  {
    $request = (new HttpRequest())
      ->withRequestTarget('/test')
      ->withMethod(HttpMethodEnum::GET);

    $this->assertEquals($request->__toString(), "GET /test HTTP/1.1\r\n\r\n");
  }
}
