<?php

namespace Hashbangcode\Webolution\Type\Element;

/**
 * Class ElementFactory
 *
 * @package Hashbangcode\Webolution\Type\Element
 */
class ElementFactory
{
  /**
   * Generate an element from a string.
   *
   * @param string $string
   *   The HTML string.
   * @return Element
   *   The constructed Element object.
   *
   * @throws \Hashbangcode\Webolution\Type\Element\Exception\InvalidChildTypeException
   */
  public static function generateFromString($string)
  {
    $dom = new \DOMDocument();
    $dom->loadHTML($string, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $parentElement = new Element($dom->firstChild->nodeName);
    if ($dom->firstChild->nodeType === XML_TEXT_NODE) {
      $parentElement->setElementText($dom->firstChild->nodeValue);
    }

    if ($dom->firstChild->hasChildNodes()) {
      self::processChildNodes($dom->firstChild->childNodes, $parentElement);
    }

    return $parentElement;
  }

  /**
   * Process a DOMNode object into nested Element objects.
   *
   * @param \DOMNode $childNodes
   *   The child nodes.
   * @param Element $parentElement
   *   The Element object.
   *
   * @throws Exception\InvalidChildTypeException
   */
  protected static function processChildNodes($childNodes, Element $parentElement)
  {
    foreach ($childNodes as $childNode) {
      if ($childNode->nodeType === XML_ELEMENT_NODE) {
        $childElement = new Element($childNode->nodeName);

        if ($childNode->hasChildNodes()) {
          if ($childNode->firstChild->nodeType === XML_TEXT_NODE) {
            $childElement->setElementText($childNode->nodeValue);
          }
        }

        $parentElement->addChild($childElement);

        if ($childNode->hasChildNodes()) {
          self::processChildNodes($childNode->childNodes, $childElement);
        }
      }
    }
  }
}