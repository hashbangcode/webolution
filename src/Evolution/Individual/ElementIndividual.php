<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Class ElementIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class ElementIndividual extends Individual {

  /**
   * @var int
   */
  protected $mutationFactor = 0.05;

  public function __construct($element) {
    if (!($element instanceof Element)) {
      $this->object = new Element($element);
    }
    else {
      $this->object = $element;
    }
  }

  /**
   * @return $this
   */
  public function mutateProperties() {
    $this->mutateElement($this->getMutationFactor());
    return $this;
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
  public function mutateElement($factor) {
    $action = mt_rand(0, 1);

    // The root element will be a HTML with a body tag child, so we grab the first body element (the useful bit).
    $rootElement = $this->getObject();
    $element = $rootElement->getChildren()[0];

    if ($action <= $factor && count($element->getAttributes()) > 0) {

      // Mutate an attribute.
      $attributes = $element->getAttributes();

      $random_attribute = array_rand($attributes);
      $letters = range('a', 'z');
      $letter = $letters[array_rand($letters)];

      $attribute_value = $attributes[$random_attribute] . $letter;

      if (strlen($attribute_value) > 10) {
        // Don't let the attribute get longer than 10 characters.
        $attribute_value = substr($attribute_value, -8);
      }

      $attributes[$random_attribute] = $attribute_value;

      $element->setAttributes($attributes);
    }
    elseif ($action >= $factor) {
        // Add additional children elements.
        $child_types = $element->getChildTypes($element->getType());
        $child_type = $child_types[array_rand($child_types)];
        $newElement = new Element($child_type);

        $newElement->setAttribute('class', 'test');

      $element->addChild($newElement);
    }
  }

  /**
   * @return int
   */
  public function getMutationFactor() {
    return $this->mutationFactor;
  }

  /**
   * @param int $mutationFactor
   */
  public function setMutationFactor($mutationFactor) {
    $this->mutationFactor = $mutationFactor;
  }

  /**
   * @return int
   */
  public function getFitness() {
    return 1;
  }

  /**
   * @param $renderType
   * @return mixed
   */
  public function render($renderType = 'cli') {
    $output = '';
    switch ($renderType) {
      case 'html':
        $output .= $this->getObject()->render();
        break;
      case 'cli':
      default:
        $output.= $this->getObject()->render() . PHP_EOL;
    }
    return $output;
  }
}