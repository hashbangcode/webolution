<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\TextPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Color\Color;

// Routes

$app->get('/', function ($request, $response, $args) {
  // Sample log message
  $this->logger->info("Index '/' route");

  // Render index view
  return $this->view->render($response, 'index.twig');
});



$app->get('/number_evolution', function ($request, $response, $args) {

  $this->logger->info("Number Eovolution '/number_evolution' route");

  $title = 'Number Evolution Test';

  $population = new NumberPopulation();
  $population->setDefaultRenderType('html');

  for ($i = 0; $i < 10; $i++) {
    $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(1));
  }

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(10);
  $evolution->setMaxGenerations(500);
  $evolution->setAllowedFitness(1);
  $evolution->setGlobalMutationFactor(1);

  $output = '';

  for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
    if ($evolution->runGeneration() === FALSE) {
      $output .= '<p>Everyone is dead.</p>';
      break;
    }
  }

  $output .= $evolution->renderGenerations();

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output
  ]);
});




$app->get('/text_evolution', function ($request, $response, $args) {

  $title = 'Text Evolution Test';

  $population = new TextPopulation();
  $population->setDefaultRenderType('html');

  for ($i = 0; $i < 1000; $i++) {
    $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\TextIndividual::generateRandomText());
  }

  $evolution = new Evolution($population);
  $evolution->setGlobalFitnessGoal('unicorn');
  $evolution->setIndividualsPerGeneration(1000);
  $evolution->setMaxGenerations(50);
  $evolution->setGlobalMutationFactor(1);

  $output = '';

  for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
    if ($evolution->runGeneration() === FALSE) {
      print '<p>Everyone is dead.</p>';
      break;
    }
  }

  $output .= $evolution->renderGenerations();

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output
  ]);
});



$app->get('/color_evolution', function ($request, $response, $args) {
  $styles = 'span {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}';

  $title = 'Color Evolution Test';

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');

  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(10);
  $evolution->setMaxGenerations(500);
  $evolution->setAllowedFitness(8);
  $evolution->setGlobalMutationFactor(1);

  $output = '';

  for ($i = 0; $i <= $evolution->getMaxGenerations(); ++$i) {
    $evolution->runGeneration();
  }

  $output .= nl2br($evolution->renderGenerations());

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});





$app->get('/colour_evolution_interactive[/{color}]', function ($request, $response, $args) {

  $title = 'Color Evolution Test';

  $styles = 'span {width:30px;height:30px;display:inline-block;padding:0px;margin:-2px;}
a, a:link, a:visited, a:hover, a:active {padding:0px;margin:0px;}
img {padding:0px;margin:0px;}';

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');

  $output = '';

  if (!isset($args['color'])) {
    $colorObject = \Hashbangcode\Wevolution\Type\Color\Color::generateFromHex('000000');
  }
  else {
    $colorObject = \Hashbangcode\Wevolution\Type\Color\Color::generateFromHex($args['color']);
    $output .= '<p><a href="/colour_evolution_interactive">Reset</a></a>';
  }

  $colorIndividual = new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual($colorObject->getRed(), $colorObject->getGreen(), $colorObject->getBlue());

  $population->addIndividual($colorIndividual);

  $evolution = new Evolution($population);

  $evolution->setGlobalMutationFactor(25);
  $evolution->setIndividualsPerGeneration(1000);

  // Run one generation.
  $evolution->runGeneration(FALSE);

  $colorPopulation = $evolution->getCurrentPopulation();

  $colorPopulation->sort('hex');

  $output .= '<p>' . PHP_EOL;

  foreach ($colorPopulation->getIndividuals() as $individual) {
    $output .= '<a href="/colour_evolution_interactive/' . $individual->getObject()->getHex() . '">' . $individual->render('html') . '</a>' . PHP_EOL;
  }
  $output .= '</p>';

  $output .= '<p>Colour<pre>' . print_r($color, TRUE) . '</pre></p>';

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});




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