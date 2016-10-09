<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

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