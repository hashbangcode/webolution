<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

//use Hashbangcode\Wevolution\Population\Exception\ElementPageRootException;
use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

class ElementPopulation extends Population
{

  protected $rootElement;

  public function __construct(ElementIndividual $root) {

    if ($root->getObject()->getType() !== 'html') {
      throw new Exception\ElementPageRootException('Root page element must be of type "html"');
    }
    $this->rootElement = $root;
  }

  public function render() {
    $output = '';
    $output .= $this->rootElement->getObject()->render();
    return $output;
  }

  /**
   * @return Element
   */
  public function getRootElement()
  {
    return $this->rootElement;
  }

  public function sort() {

  }

  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      //$individual = ::generateRandomColor();
    }

    $this->individuals[] = $individual;
  }
}