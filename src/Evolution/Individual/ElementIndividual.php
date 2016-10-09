<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Class ElementIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class ElementIndividual extends Individual
{

  /**
   * @var int
   */
  protected $mutationFactor = 1;

  /**
   * @return int
   */
  public function getMutationFactor()
  {
    return $this->mutationFactor;
  }

  /**
   * @param int $mutationFactor
   */
  public function setMutationFactor($mutationFactor)
  {
    $this->mutationFactor = $mutationFactor;
  }

  public function __construct(Element $element) {
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
   * @return int
   */
  public function getFitness() {
    return 1;
  }

  /**
   * @param $renderType
   * @return mixed
   */
  public function render($renderType) {
    return $this->getObject()->render($renderType);
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
    $action = mt_rand(0, 1);

    if ($action <= $factor && count($this->getObject()->getAttributes()) > 0) {
      // Mutate an attribute.

      $attributes = $this->getObject()->getAttributes();

      $random_attribute = array_rand($attributes);
      $letters = range('a', 'z');
      $letter = $letters[array_rand($letters)];

      $attribute_value = $attributes[$random_attribute] . $letter;

      if (strlen($attribute_value) > 10) {
        // Don't let the attribute get longer than 10 characters.
        $attribute_value = substr($attribute_value, -8);
      }

      $attributes[$random_attribute] = $attribute_value;

      $this->getObject()->setAttributes($attributes);
    }
    else if ($action >= $factor) {
      // Add additional children elements.
      $child_types = $this->getObject()->getChildTypes($this->getObject()->getType());
      $this->getObject()->addChild(new Element($child_types[array_rand($child_types)]));
    }
  }
}