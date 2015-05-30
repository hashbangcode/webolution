<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function () {
  $output = 'Hi';

  $output .= '<p><a href="/number_evolution">Number Evolution</a></p>';

  return $output;
});


$app->get('/number_evolution', function () {
  $output = '<h1>Number Evolution Test</h1>';

  $numberPopulation = new NumberPopulation();

  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(1));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(2));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(3));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(4));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(5));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(6));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(7));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(8));
  $numberPopulation->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(9));

  $evolution = new Evolution($numberPopulation);
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

