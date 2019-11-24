<?php

declare(strict_types=1);

namespace fall\http\client;

use fall\mvc\web\message\http\HttpRequest;
use fall\mvc\web\message\http\Uri;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
interface ClientHttpRequestFactory
{
  function createRequest(Uri $uri): HttpRequest;
}
