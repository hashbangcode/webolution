<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

$app->get('/element_creation_test', function ($request, $response, $args) {
  $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}';

  $title = 'Element Creation Test';

  $population = new ElementPopulation();

  $html = new Element('html');
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

  $population->setDefaultRenderType('htmltextarea');
  $output .= $population->render();

  $population->setDefaultRenderType('html');
  $output .= $population->render();

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});

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