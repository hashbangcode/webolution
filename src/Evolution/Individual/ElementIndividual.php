<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Class ColorIndividual
 */
class ElementIndividual extends Individual
{
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

  public function __construct($element) {
    if (!($element instanceof Element)) {
      $this->object = new Element($element);
    }
    else {
      $this->object = $element;
    }
  }

  public function mutateProperties() {
    $this->getObject()->mutateElement($this->getMutationFactor());
    return $this;
  }

  public function getFitness() {
    return 1;
  }

  public function render() {
    return $this->getObject()->render();
  }
}