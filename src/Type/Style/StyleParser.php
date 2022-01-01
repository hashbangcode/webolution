<?php

namespace Hashbangcode\Webolution\Type\Style;

use Hashbangcode\Webolution\TypeParserInterface;
use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\Type\Style\Exception\InvalidStyleValueException;

/**
 * Class StyleParser.
 *
 * @package Hashbangcode\Webolution\Type\Style
 */
class StyleParser implements TypeParserInterface
{

  /**
   * {@inheritdoc}
   */
  public static function parse($string): TypeInterface
  {
    preg_match_all('/\s*(?<selector>[^{]+)\s*\{\s*(?<attributes>[^}]*?)\s*}/', trim($string), $matches);

    if (!isset($matches['selector'][0])) {
      throw new InvalidStyleValueException();
    }

    $selector = $matches['selector'][0];

    $attributes = array_filter(explode(';', $matches['attributes'][0]));

    $style = new Style();
    $style->setSelector($selector);

    foreach ($attributes as $attribute) {
      list($name, $value) = explode(':', $attribute);
      $style->setAttribute($name, $value);
    }

    return $style;
  }
}
