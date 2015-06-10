<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function () {
  $output = 'Hi';

  $output .= '<p><a href="/number_evolution">Number Evolution</a></p>';
  $output .= '<p><a href="/color_evolution">Color Evolution</a></p>';

  return $output;
});

$app->get('/color_evolution', function () {
  $output = '<h1>Color Evolution Test</h1>';

  $output .= '<style>div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}</style>';

  $population = new ColorPopulation();

  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(0, 0, 0));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(125, 125, 125));
  /*$population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(4));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(5));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(6));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(7));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(8));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(9));*/

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(20);
  $evolution->setMaxGenerations(100);
  $evolution->setAllowedFitness(6);
  $evolution->setGlobalMutationFactor(100);

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
  $evolution->setIndividualsPerGeneration(20);
  $evolution->setMaxGenerations(100);
  $evolution->setAllowedFitness(6);
  $evolution->setGlobalMutationFactor(1);

  for ($i = 0; $i <= $evolution->getMaxGenerations(); ++$i) {
    $evolution->runGeneration();
  }

  $output .= '<br>';

  $output .= nl2br($evolution->renderGenerations());

  return $output;
});

$app->run();

