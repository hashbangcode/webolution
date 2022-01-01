<?php

namespace Hashbangcode\Webolution\Type\Page;

use Hashbangcode\Webolution\Type\Element\ElementParser;
use Hashbangcode\Webolution\Type\Style\StyleParser;
use Hashbangcode\Webolution\TypeParserInterface;
use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class PageParser.
 *
 * @package Hashbangcode\Webolution\Type\Page
 */
class PageParser implements TypeParserInterface
{

  /**
   * {@inheritdoc}
   */
  public static function parse($string): TypeInterface
  {
    $page = new Page();

    preg_match_all('/\<style\>(?<styles>.*)\<\/style\>/s', $string, $styles);

    if (isset($styles['styles'])) {
      $styles = array_filter(explode("\n", $styles['styles'][0]), 'trim');
      $styleObjects = [];
      foreach ($styles as $style) {
        $styleObjects[] = StyleParser::parse($style);
      }
      $page->setStyles($styleObjects);
    }

    preg_match_all('/\<body\>(.*)\<\/body\>/s', $string, $body);

    if (isset($body[1][0])) {
      $element = ElementParser::parse($body[1][0]);
      $page->setBody($element);
    }

    return $page;
  }
}
