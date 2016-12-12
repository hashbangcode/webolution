<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

$app->get('/color_sort[/{type}]', function ($request, $response, $args) {
  $styles = 'span {width:1px;height:10px;display:inline-block;padding:0px;margin:0px;}
a, a:link, a:visited, a:hover, a:active {padding:0px;margin:0px;}
img {padding:0px;margin:0px;}';

  $title = 'Color Evolution Sort';

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');


   for ($i = 0; $i < 1200; ++$i) {
     $population->addIndividual();
     //$population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex($i)));
  }

/*
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("777777")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("000000")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("FFFFFF")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("A70605")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("BADA66")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("AAAAAA")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("111111")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("999999")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("AADA55")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("555555")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("BADA44")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("987865")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("123345")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("BADA55")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("EEEEEE")));
  $population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual::generateFromColor(\Hashbangcode\Wevolution\Type\Color\Color::generateFromHex("BADA55")));
*/

  if (!isset($args['type'])) {
    $args['type'] = '';
  }

  switch ($args['type']) {
    case 'hue':
      $population->sort('hue');
      break;
    case 'hex':
      $population->sort('hex');
      break;
    case 'intensity':
      $population->sort('intensity');
      break;
    case 'hsi_saturation':
      $population->sort('hsi_saturation');
      break;
    case 'lightness':
      $population->sort('lightness');
      break;
    case 'fitness':
      $population->sort('fitness');
      break;
    case 'none':
      break;
    default:
      $population->sort();
  }


  $output = '';

  foreach ($population->getIndividuals() as $individual) {
    $output .= $individual->render($population->getDefaultRenderType());
  }

  ///$output .= nl2br($population->render());


  $output .= '<p>Sort by:';
  $output .= '<ul>';
  $output .= '<li><a href="/color_sort/hue">hue</a></li>';
  $output .= '<li><a href="/color_sort/hex">hex</a></li>';
  $output .= '<li><a href="/color_sort/intensity">intensity</a></li>';
  $output .= '<li><a href="/color_sort/hsi_saturation">hsi_saturation</a></li>';
  $output .= '<li><a href="/color_sort/lightness">lightness</a></li>';
  $output .= '<li><a href="/color_sort/fitness">fitness (i.e. backwards lightness)</a></li>';
  $output .= '<li><a href="/color_sort">default (i.e. hue)</a></li>';
  $output .= '<li><a href="/color_sort/none">no sort</a></li>';
  $output .= '</p>';

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
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
  $evolution->setIndividualsPerGeneration(20);
  $evolution->setMaxGenerations(250);
  $evolution->setGlobalMutationFactor(0.5);

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

  $output .= '<p>';

  foreach ($colorPopulation->getIndividuals() as $individual) {
    $output .= '<a href="/colour_evolution_interactive/' . $individual->getObject()->getHex() . '">' . $individual->render('html') . '</a>' . PHP_EOL;
  }
  $output .= '</p>';

  $output .= '<p>Colour<pre>' . $colorObject->render() . '</pre></p>';

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});


$app->get('/color_evolution_storage[/{evolutionid}]', function ($request, $response, $args) {

  $title = 'Colour Evolution Database Test';

  $styles = 'span {width:30px;height:30px;display:inline-block;padding:0px;margin:-2px;}
a, a:link, a:visited, a:hover, a:active {padding:0px;margin:0px;}
img {padding:0px;margin:0px;}';

  $database = realpath(__DIR__ . '/../../database') . '/database.sqlite';
  $evolution = new EvolutionStorage();

  $evolution->setEvolutionId(1);

  $evolution->setupDatabase('sqlite:' . $database);

  $evolution->setIndividualsPerGeneration(5000);
  $evolution->setGlobalMutationFactor(0.1);

  $generation = $evolution->getGeneration();

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');

  if ($generation == 1) {
    $population->addIndividual();

    $evolution->setPopulation($population);
  }
  else {
    $evolution->setPopulation($population);
    $evolution->loadPopulation();
  }

  $evolution->runGeneration();

  $output = '';

  $output .= '<p>Generation: ' . $evolution->getGeneration() . '</p>';

  $output .= nl2br($evolution->renderGenerations());


  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);

});