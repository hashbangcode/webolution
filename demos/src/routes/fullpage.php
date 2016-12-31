<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;

$app->get('/fullpage_test', function ($request, $response, $args) {
  $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}.elementframe{width:500px;height:500px;}';

  $title = 'Full Page Test';

  $population = new ElementPopulation();

  $html = new Element('html');
  $head = new Element('head');

  $style = new Element('style');
  $style_object = new StyleIndividual('.text');
  $style_element = new Element($style_object);
  $style->addChild($style_element);

  $head->addChild($style);

  $html->addChild($head);

  $body = new Element('body');
  $div = new Element('div');
  $p1 = new Element('p');
  $p2 = new Element('p');
  $p3 = new Element('p');

  $div->addChild($p1);
  $div->addChild($p2);
  $div->addChild($p3);
  $body->addChild($div);
  $html->addChild($body);

  $element_individual = new ElementIndividual($html);

  $population->addIndividual($element_individual);

  $output = '';

  $output .= '<h2>HTML</h2>';

  $population->setDefaultRenderType('htmltextarea');
  $output .= $population->render();

  $output .= '<br>';

  $output .= '<h2>iFrame</h2>';

  $population->setDefaultRenderType('html');
  $output .= $population->render();

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});
