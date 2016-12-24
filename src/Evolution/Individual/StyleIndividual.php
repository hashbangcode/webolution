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
    switch ($renderType) {
      case 'html':
        return $this->getObject()->render();
      case 'cli':
      default:
        return $this->getObject()->render() . PHP_EOL;
    }
  }
}