<?php

namespace Hashbangcode\Webolution\Type\Number;

use Hashbangcode\Webolution\TypeParserInterface;
use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\Type\Number\Exception\InvalidNumberException;

/**
 * Class ColorParser.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class NumberParser implements TypeParserInterface
{

  /**
   * {@inheritdoc}
   */
  public static function parse($string): TypeInterface
  {
    if (false === is_numeric($string)) {
      throw new InvalidNumberException($string . ' is not a number.');
    }
    return new Number((int)$string);
  }
}
