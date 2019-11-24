<?php

declare(strict_types=1);

namespace fall\http\message;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
abstract class HttpMethodEnum
{
  const GET = 'GET';
  const HEAD = 'HEAD';
  const POST = 'POST';
  const PUT = 'PUT';
  const DELETE = 'DELETE';
  const OPTIONS = 'OPTIONS';
  const TRACE = 'TRACE';
  const PATCH = 'PATCH';
}
