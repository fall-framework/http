<?php

declare(strict_types=1);

namespace fall\http\message;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
abstract class HttpProtocolVersionEnum
{
  const HTTP_1_0 = "1.0";
  const HTTP_1_1 = "1.1";
  const HTTP_2_0 = "2.0";
}
