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
    $this->getObject()->mutateElement($this->getMutationFactor());
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
}