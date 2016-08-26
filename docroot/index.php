<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

require_once __DIR__.'/../vendor/autoload.php';

define(WEVOLUTION_INDIVIDUALS_PER_GENERATION, 20);
define(WEVOLUTION_MAX_GENERATIONS, 2000);


$app = new Silex\Application();

$app->get('/', function () {
  $output = 'Hi';

  $output .= '<p><a href="/number_evolution">Number Evolution</a></p>';
  $output .= '<p><a href="/color_evolution">Color Evolution</a></p>';
  $output .= '<p><a href="/colour_evolution_interactive">Color Evolution Interactive</a></p>';

  return $output;
});

$app->get('/color_evolution', function () {
  $output = '<h1>Color Evolution Test</h1>';

  $output .= '<style>div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}</style>';

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');

  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(0, 0, 0));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(125, 125, 125));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(123, 0, 172));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(0, 0, 255));

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(WEVOLUTION_INDIVIDUALS_PER_GENERATION);
  $evolution->setMaxGenerations(WEVOLUTION_MAX_GENERATIONS);
  $evolution->setAllowedFitness(8);
  $evolution->setGlobalMutationFactor(1);

  for ($i = 0; $i <= $evolution->getMaxGenerations(); ++$i) {
    $evolution->runGeneration();
  }

  $output .= '<br>';

  $output .= nl2br($evolution->renderGenerations());

  return $output;
});

$app->get('/number_evolution', function () {
  $output = '<h1>Number Evolution Test</h1>';

  $population = new NumberPopulation();
  $population->setDefaultRenderType('html');

  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(1));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(2));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(3));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(4));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(5));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(6));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(7));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(8));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(9));

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(WEVOLUTION_INDIVIDUALS_PER_GENERATION);
  $evolution->setMaxGenerations(WEVOLUTION_MAX_GENERATIONS);
  $evolution->setAllowedFitness(6);
  $evolution->setGlobalMutationFactor(1);

  for ($i = 0; $i <= $evolution->getMaxGenerations(); ++$i) {
    $evolution->runGeneration();
  }

  $output .= '<br>';

  $output .= $evolution->renderGenerations();

  return $output;
});

$app->get('/colour_evolution_interactive', function () {

  $output = '<h1>Test</h1>';

  $output .= '<style>div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}</style>';

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');



  return $output;
});

$app->run();

