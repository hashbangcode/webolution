<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

//use Hashbangcode\Wevolution\Population\Exception\ElementPageRootException;
use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

/**
 * Class ElementPopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class ElementPopulation extends Population {

  /**
   * @var \Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual
   */
  protected $rootElement;

  /**
   * ElementPopulation constructor.
   * @param \Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual $root
   */
  public function __construct(ElementIndividual $root) {

    if ($root->getObject()->getType() !== 'html') {
      throw new Exception\ElementPageRootException('Root page element must be of type "html"');
    }
    $this->rootElement = $root;
  }

  /**
   * @return string
   */
  public function render() {
    $output = '';
    $output .= $this->rootElement->getObject()->render();
    return $output;
  }

  /**
   * @return Element
   */
  public function getRootElement() {
    return $this->rootElement;
  }

  /**
   *
   */
  public function sort() {

  }

  /**
   * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|NULL $individual
   */
  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      //$individual = ::hjgfhj();
    }

    $this->individuals[] = $individual;
  }
}