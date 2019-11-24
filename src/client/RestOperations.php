<?php
declare(strict_types=1);


namespace fall\http\client;

/**
 * @author Angelis <angelis@users.noreply.github.com>
 */
interface RestOperations
{
  /**
   * @param $url
   * @param $responseType
   * @param $urlVariables
   */
  function getForObject(string $url, $responseType, array $uriVariables = array());
}
