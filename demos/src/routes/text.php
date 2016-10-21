<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\TextPopulation;
use Hashbangcode\Wevolution\Evolution\Individual\TextIndividual;

$app->get('/text_evolution', function ($request, $response, $args) {

  $title = 'Text Evolution Test';

  $population = new TextPopulation();
  $population->setDefaultRenderType('html');

  $goal = 'Monkey say monkey do';

  for ($i = 0; $i < 10; $i++) {
    $population->addIndividual(TextIndividual::generateRandomText(strlen($goal)));
  }

  $evolution = new Evolution($population);
  $evolution->setGlobalFitnessGoal($goal);
  $evolution->setIndividualsPerGeneration(10);
  $evolution->setMaxGenerations(1000);
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



$app->get('/text_evolution_length', function ($request, $response, $args) {

  $title = 'Text Evolution Test With Different Length Goal';

  $population = new TextPopulation();
  $population->setDefaultRenderType('html');

  $goal = 'monkey';

  for ($i = 0; $i < 10; $i++) {
    $population->addIndividual(TextIndividual::generateRandomText(15));
  }

  $evolution = new Evolution($population);
  $evolution->setGlobalFitnessGoal($goal);
  $evolution->setIndividualsPerGeneration(10);
  $evolution->setMaxGenerations(1000);
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