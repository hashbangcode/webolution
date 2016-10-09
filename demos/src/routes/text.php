<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\TextPopulation;

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