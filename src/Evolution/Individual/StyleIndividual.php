<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Style\Style;

/**
 * Class StyleIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class StyleIndividual extends Individual
{

  /**
   * @var int
   */
  protected $mutationFactor = 0.05;

  /**
   * StyleIndividual constructor.
   * @param $element
   */
  public function __construct($element)
  {
    if (!($element instanceof Style)) {
      $this->object = new Style($element);
    } else {
      $this->object = $element;
    }
  }

  /**
   * @return $this
   */
  public function mutateProperties()
  {
    $this->mutateStyle($this->getMutationFactor());
    return $this;
  }

  /**
   * Mutate the element.
   *
   * @param $factor The amount of variance to apply.
   */
  public function mutateStyle($factor)
  {
    $action = mt_rand(0, 100);

    $action = $action + $factor;

    $style = $this->getObject();

    if ($action <= 5 && count($style->getAttributes()) > 0) {
      // Mutate selector
      $selector = $style->getSelector();

      //$selector = $this->mutateSelector();

      $this->getObject()->setSelector($selector);
    } elseif ($action > 5 && $action <= 50) {
      // Add a attribute to the Style.

    } else {
      // Select an attribute and mutate it.
      $attributes = $style->getAttributes();
      $selectedAttribute = array_rand($attributes);
      $attributes[$selectedAttribute] = $this->mutateAttribute($selectedAttribute, $attributes[$selectedAttribute]);
    }
  }

  /**
   * @param $attribute
   * @param $attributeProperty
   * @return mixed
   */
  public function mutateAttribute($attribute, $attributeProperty)
  {

    switch ($attribute) {
      case 'color':

        $attributeProperty->mutateColor(1000);

        break;
    }

    return $attributeProperty;
  }

  /**
   * @return int
   */
  public function getFitness()
  {
    return 1;
  }

  /**
   * @param $renderType
   * @return mixed
   */
  public function render($renderType = 'cli')
  {
    $output = '';
    switch ($renderType) {
      case 'html':
        $output .= $this->getObject()->render() . '<br>';
        break;
      case 'cli':
      default:
        $output .= $this->getObject()->render() . PHP_EOL;
    }
    return $output;
  }
}