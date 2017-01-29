<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Wevolution\Type\Page\Page;

/**
 * Class ElementPopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class PagePopulation extends Population
{

  /**
   * @return string
   */
  public function render()
  {
    $output = '';

    // Ensure that the items are sorted.
    $this->sort();

    foreach ($this->getIndividuals() as $individual) {

      $renderType = $this->getDefaultRenderType();

      switch ($renderType) {
        case 'html':
          $output .= '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $individual->render($renderType) . '\'></iframe>';
          break;

        case 'htmltextarea':
          $output .= '<textarea rows="10" cols="25">' . $individual->render($renderType) . '</textarea>';
          break;

        case 'htmlfull':
          $output .= '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $individual->render($renderType) . '\'></iframe>';
          $output .= '<textarea rows="35" cols="35">' . $individual->render($renderType) . '</textarea>';
          break;

        case 'cli':
        default:
          $output .= $individual->render($renderType) . PHP_EOL;
      }
    }

    return $output;
  }

  /**
   *
   */
  public function sort()
  {

  }

  /**
   * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|NULL $individual
   */
  public function addIndividual(Individual $individual = NULL)
  {
    if (is_null($individual)) {
      $html = new Element('html');
      $body = new Element('body');
      $html->addChild($body);

      $individual = new ElementIndividual($html);
    }

    if ($individual->getObject()->getType() !== 'html') {
      throw new Exception\ElementPageRootException('Root page element must be of type "html"');
    }

    $this->individuals[] = $individual;
  }
}