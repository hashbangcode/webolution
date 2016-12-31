<?php

namespace Hashbangcode\Wevolution\Type\Element;

use Hashbangcode\Wevolution\Utilities\TextUtilities;

class Element
{

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
   * An object.
   *
   * @var bool|object
   */
  protected $object = FALSE;

  /**
   * @return bool|object
   */
  public function getObject()
  {
    return $this->object;
  }

  /**
   * @param bool|object $object
   */
  public function setObject($object)
  {
    $this->object = $object;
  }

  /**
   * Element constructor.
   * @param string $type
   */
  public function __construct($arg = 'div')
  {
    if (is_object($arg)) {
      // This is an object so we store it differently.
      $this->type = false;
      $this->object = $arg;
    }
    else {
      // This is a string so we create a normal Element object.
      $this->type = $arg;

      if (in_array($arg, $this->getTextTypes())) {
        $this->elementText = $this->generateRandomText(10);
      }
    }
  }

  /**
   * @return array
   */
  public function getTextTypes()
  {
    return array('p', 'li', 'h1', 'h2', 'h3', 'h4', 'h5');
  }

  /**
   * @param $key
   * @param $value
   */
  public function setAttribute($key, $value)
  {
    $this->attributes[$key] = $value;
  }

  /**
   * @return string
   */
  public function render()
  {
    $output = '';
    if ($this->getType() === false && is_object($this->getObject())) {
      return $this->getObject()->render();
    }

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
   * @return mixed
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * @param mixed $type
   */
  public function setType($type)
  {
    $this->type = strtolower($type);
  }

  /**
   * @return mixed
   */
  public function getAttributes()
  {
    return $this->attributes;
  }

  /**
   * @param $attributes
   * @throws Exception\InvalidAttributesException
   */
  public function setAttributes($attributes)
  {
    if (!is_array($attributes)) {
      throw new Exception\InvalidAttributesException('Array of attributes required.');
    }

    $this->attributes = $attributes;
  }

  /**
   * @return array
   */
  public function getChildren()
  {
    return $this->children;
  }

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
   * @param Element $element
   */
  public function addChild(Element $element)
  {
    // @todo : validate the child element type
    $this->children[] = $element;
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
  public function getChildTypes($type)
  {
    if ($type === false) {
      return false;
    }

    switch ($type) {
      case 'ul':
      case 'ol':
        return array('li');
      default :
        return array('ul', 'ol', 'div', 'p', 'h1', 'h2');
    }
  }

  /**
   *
   */
  public function __clone()
  {
    // Clone the children of this object.
    foreach ($this->children as $key => $child) {
      // When cloning a child all children will also be cloned.
      $this->children[$key] = clone $child;
    }
  }
}