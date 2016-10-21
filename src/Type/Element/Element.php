<?php

namespace Hashbangcode\Wevolution\Type\Element;

use Hashbangcode\Wevolution\Utilities\TextUtilities;

class Element {

  use TextUtilities;

  /**
   * @var string
   */
  protected $type;

  /**
   * @var
   */
  protected $attributes;

  /**
   * @var array
   */
  protected $children = array();

  /**
   * @var string
   */
  protected $elementText = '';

  /**
   * @return string
   */
  public function getElementText()
  {
    return $this->elementText;
  }

  /**
   * @param string $elementText
   */
  public function setElementText($elementText)
  {
    $this->elementText = $elementText;
  }

  /**
   * Element constructor.
   * @param string $type
   */
  public function __construct($type = 'div') {
    $this->type = $type;

    if (in_array($type, $this->getTextTypes())) {
      $this->elementText = $this->generateRandomText(10);
    }
  }

  /**
   * @return mixed
   */
  public function getAttributes() {
    return $this->attributes;
  }

  /**
   * @param $attributes
   * @throws Exception\InvalidAttributesException
   */
  public function setAttributes($attributes) {
    if (!is_array($attributes)) {
      throw new Exception\InvalidAttributesException('Array of attributes required.');
    }

    $this->attributes = $attributes;
  }

  /**
   * @param $key
   * @param $value
   */
  public function setAttribute($key, $value) {
    $this->attributes[$key] = $value;
  }

  /**
   * @return mixed
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @param mixed $type
   */
  public function setType($type) {
    $this->type = strtolower($type);
  }

  public function render() {
    $output = '';
    $output .= '<' . $this->getType();

    if ($this->getAttributes() > 0) {
      $attributes = array();
      foreach ($this->getAttributes() as $attribute => $value) {
        $attributes[] = $attribute . '="' . $value . '"';
      }
      $output .= ' ' . implode(' ', $attributes);
    }

    $output .= '>';

    if (count($this->getChildren()) > 0) {
      foreach ($this->getChildren() as $index => $child) {
        $output .= $child->render();
      }
    }

    $output .= $this->getElementText();

    $output .= '</' . $this->getType() . '>';
    return $output;
  }

  /**
   * @param Element $element
   */
  public function addChild(Element $element) {
    // @todo : validate the child element type
    $this->children[] = $element;
  }

  /**
   * @return array
   */
  public function getChildren() {
    return $this->children;
  }

  /**
   * Get the child type appropriate for the current element.
   *
   * This method is intended to stop (for example) li elements being children of
   * div elements and allows a more symantically correct page to be generated.
   *
   * @param $type
   * @return array
   */
  public function getChildTypes($type) {

    switch ($type) {

      case 'ul':
      case 'ol':
        return array('li');
      default :
        return array('ul', 'ol', 'div', 'p', 'h1', 'h2');
    }
  }

  /**
   * @return array
   */
  public function getTextTypes() {
    return array('p', 'li', 'h1', 'h2');
  }
}