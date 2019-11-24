<?php

declare(strict_types=1);

namespace fall\http\client;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
interface ClientCurlFactory
{
  function createCurl(array $opts = array()): Curl;
}
