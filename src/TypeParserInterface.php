<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Type\TypeInterface;

interface TypeParserInterface
{

  /**
   * Parse a string into a Type object.
   *
   * @param string $string
   *   The string to parse into a Type object.
   *
   * @return TypeInterface
   *   The type object.
   */
  public static function parse($string): TypeInterface;
}
