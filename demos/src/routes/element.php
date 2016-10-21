<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

$app->get('/element_evolution', function ($request, $response, $args) {
  $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}';

  $title = 'Element Evolution Test';

  $population = new ElementPopulation();
  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));

  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));
  $population->addIndividual(new ElementIndividual(new Element('html')));

  $population->setDefaultRenderType('html');
  $population->setDefaultRenderType('htmltextarea');

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(10);
  $evolution->setMaxGenerations(5);
//  $evolution->setGlobalMutationFactor(1);

  for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
    if ($evolution->runGeneration() === FALSE) {
      print '<p>Everyone is dead.</p>';
      break;
    }
  }

  $output = '';
  $output .= $evolution->renderGenerations();

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});