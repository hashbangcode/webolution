<?php

namespace Hashbangcode\Wevolution\Type\Element;

class Page
{

  protected $rootElement;

  public function __construct(Element $root) {
    if ($root->getType() !== 'html') {
      throw new Exception\PageRootException('Root page element must be of type "html"');
    }
    $this->rootElement = $root;
  }

  public function render() {
    $output = '';
    $output .= $this->rootElement->render();
    return $output;
  }

  /**
   * @return Element
   */
  public function getRootElement()
  {
    return $this->rootElement;
  }
}