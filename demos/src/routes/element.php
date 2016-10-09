<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;

$app->get('/element_evolution', function ($request, $response, $args) {
  $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}';

  $title = 'Element Evolution Test';

  $rootElement = new \Hashbangcode\Wevolution\Type\Element\Element('html');
  $root = new \Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual($rootElement);
  $population = new ElementPopulation($root);
  $population->setDefaultRenderType('html');

  $element = new \Hashbangcode\Wevolution\Type\Element\Element();

  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual($element));

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(5);
  $evolution->setMaxGenerations(10);
  $evolution->setGlobalMutationFactor(1);

  $output = '';

  for ($i = 0; $i <= $evolution->getMaxGenerations(); ++$i) {
    $evolution->runGeneration();
  }


  $output .= '<textarea>';
  $output .= nl2br($evolution->renderGenerations());
  $output .= '</textarea>';

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});