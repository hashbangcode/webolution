<?php

namespace Hashbangcode\Webolution\Type\Element;

use Hashbangcode\Webolution\TypeParserInterface;
use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class ElementParser.
 *
 * @package Hashbangcode\Webolution\Type\Element
 */
class ElementParser implements TypeParserInterface
{

  /**
   * {@inheritdoc}
   */
  public static function parse($string): TypeInterface
  {
    return ElementFactory::generateFromString($string);
  }
}
