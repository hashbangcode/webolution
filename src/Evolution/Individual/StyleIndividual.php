<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Style\Style;

/**
 * Class ElementIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class StyleIndividual extends Individual {

  /**
   * @var int
   */
  protected $mutationFactor = 0.05;

  public function __construct($element) {
    if (!($element instanceof Style)) {
      $this->object = new Style($element);
    }
    else {
      $this->object = $element;
    }
  }

  /**
   * @return $this
   */
  public function mutateProperties() {
    $this->mutateStyle($this->getMutationFactor());
    return $this;
  }

  /**
   * Mutate the element.
   *
   * @param $factor The amount of variance to apply.
   */
  public function mutateStyle($factor) {
    $action = mt_rand(0, 1);

    $style = $this->getObject();

    if ($action <= $factor && count($style->getAttributes()) > 0) {
      // Select an attribute and mutate it.
      $attributes = $style->getAttributes();
      $selectedAttribute = array_rand($attributes);
      $attributes[$selectedAttribute] = $this->mutateAttribute($selectedAttribute, $attributes[$selectedAttribute]);
    }
    elseif ($action >= $factor) {
      // Mutate selector
      $selector = $style->getSelector();

      // ???

      $this->getObject()->setSelector($selector);
    }
    else {
      // Add a attribute to the Style.

    }
  }

  public function mutateAttribute($attribute, $attributeProperty) {

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
        $output .= $this->getObject()->render() . '<br>';
        break;
      case 'cli':
      default:
        $output .= $this->getObject()->render() . PHP_EOL;
    }
    return $output;
  }
}