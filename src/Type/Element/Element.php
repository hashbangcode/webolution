<?php

namespace Hashbangcode\Wevolution\Type\Element;

class Element
{

  protected $type;
  protected $attributes;
  protected $children = array();

  public function __construct($type = 'div') {
    $this->type = $type;
  }

  /**
   * @return mixed
   */
  public function getAttributes()
  {
    return $this->attributes;
  }

  /**
   * @param mixed $attributes
   */
  public function setAttributes($attributes)
  {
    if (!is_array($attributes)) {
      throw new Exception\InvalidAttributesException('Array of attributes required.');
    }

    $this->attributes = $attributes;
  }

  public function setAttribute($key, $value) {
    $this->attributes[$key] = $value;
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

  public function render() {
    $output = '';
    $output .= '<' . $this->getType();

    if ($this->getAttributes() > 0) {
      $attributes = array();
      foreach ($this->getAttributes() as $attribute => $value) {
        $attributes[] = $attribute .'="' . $value . '"';
      }
      $output .= ' ' . implode(' ', $attributes);
    }

    $output .= '>';
    if (count($this->getChildren()) > 0) {
      foreach ($this->getChildren() as $index => $child) {
        $output .= $child->render();
      }
    }

    $output .= '</' . $this->getType() . '>';
    return  $output;
  }

  public function addChild(Element $element) {
    // @todo : validate the child element type
    $this->children[] = $element;
  }

  public function getChildren() {
    return $this->children;
  }

  /**
   * Mutate the element.
   *
   * Possible actions to take during mutation.
   * - Alter attributes (9/10).
   * - Add additional children (1/10).
   *
   * This should not alter the tag itself. Also, certain elements
   * should only get certain children. For example, a ul
   * or a ol element should only get a li or a.
   *
   * @param $factor The amount of variance to apply.
   */
  public function mutateElement($factor)
  {
    $action = rand(1, 10) + $factor;

    if ($action <= 9 && count($this->attributes) > 0) {
      // Mutate an attribute.
      $random_attribute = array_rand($this->attributes);
      $letters = range('a', 'z');
      $letter = $letters[array_rand($letters)];

      $attribute_value = $this->attributes[$random_attribute] . $letter;

      if (strlen($attribute_value) > 10) {
        // Don't let the attribute get longer than 10 characters.
        $attribute_value = substr($attribute_value, -8);
      }

      $this->attributes[$random_attribute] = $attribute_value;
    }
    else if ($action >= 10) {
      // Add additional children elements.
      $child_types = $this->getChildTypes($this->getType());
      $this->addChild(new Element($child_types[array_rand($child_types)]));
    }
  }

  public function getChildTypes($type) {

    switch ($type) {

      case 'ul':
      case 'ol':
        return array('li');
      default :
        return array('ul', 'ol', 'div', 'p', 'h1');
    }
  }
}