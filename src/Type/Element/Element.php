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
    $this->children[] = $element;
  }

  public function getChildren() {
    return $this->children;
  }


}