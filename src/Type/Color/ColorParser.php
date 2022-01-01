<?php

namespace Hashbangcode\Webolution\Type\Color;

use Hashbangcode\Webolution\TypeParserInterface;
use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class ColorParser.
 *
 * @package Hashbangcode\Webolution\Type\Color
 */
class ColorParser implements TypeParserInterface
{

  /**
   * {@inheritdoc}
   */
  public static function parse($string): TypeInterface
  {
    return ColorFactory::generateFromHex($string);
  }
}
