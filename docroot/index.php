<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;
use Hashbangcode\Wevolution\Type\Color\Color;

date_default_timezone_set('Europe/London');
define('WEVOLUTION_INDIVIDUALS_PER_GENERATION', 10);
define('WEVOLUTION_MAX_GENERATIONS', 300);

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// Register TWIG
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/views',
));

$app['debug'] = true;


$app->get('/number_evolution', function () {
  $output = '';

  //$output .= '<h1>Number Evolution Test</h1>';

  $population = new NumberPopulation();
  $population->setDefaultRenderType('html');

  for ($i = 0; $i < WEVOLUTION_INDIVIDUALS_PER_GENERATION; $i++) {
    $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(1));
    //$population->addIndividual(\Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual::generateRandomNumber());
  }


  /*$population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(-2));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(2));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(3));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(4));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(5));*/
  /*$population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(6));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(7));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(8));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(9));
  */

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(WEVOLUTION_INDIVIDUALS_PER_GENERATION);
  $evolution->setMaxGenerations(WEVOLUTION_MAX_GENERATIONS);
  $evolution->setAllowedFitness(1);
  $evolution->setGlobalMutationFactor(1);

  for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
    if ($evolution->runGeneration() === FALSE) {
      print '<p>Everyone is dead.</p>';
      break;
    }
  }

  $output .= '<br>';

  $output .= $evolution->renderGenerations();

  return $output;
});


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

  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));
  $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual(255, 255, 255));


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

$app->get('/colour_evolution_interactive/{color}', function ($color) use ($app) {

  $output = '<h1>Test</h1>';

  $styles = '<style>div {width:50px;height:50px;display:inline-block;padding:0px;margin:0px;}</style>';

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');

  if ($color == '') {
    $colorObject = \Hashbangcode\Wevolution\Type\Color\Color::generateFromHex('000000');
  }
  else {
    $colorObject = \Hashbangcode\Wevolution\Type\Color\Color::generateFromHex($color);
  }

  $colorIndividual = new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual($colorObject->getRed(), $colorObject->getGreen(), $colorObject->getBlue());

  $population->addIndividual($colorIndividual);
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();
  $population->copyIndividual();

  $evolution = new Evolution($population);

  //$evolution->setIndividualsPerGeneration(WEVOLUTION_INDIVIDUALS_PER_GENERATION);
  //$evolution->setMaxGenerations(WEVOLUTION_MAX_GENERATIONS);
  $evolution->setGlobalMutationFactor(100);
  // Run one generation.
  $evolution->runGeneration(FALSE);

  $colorPopulation = $evolution->getCurrentPopulation();

  $colorPopulation->sort();

  $output .= '<p>' . PHP_EOL;

  foreach ($colorPopulation->getIndividuals() as $individual) {
    $output .= $individual->getObject()->getHex() ;
    $output .= '<a href="/colour_evolution_interactive/' . $individual->getObject()->getHex() . '">' . $individual->render('html') . '</a>' . PHP_EOL;
  }
  $output .= '</p>';

  //foreach ($evolution->getCurrentPopulation()->getIndividuals() as $individual) {
    //$colorIndividual->setMutationFactor(10);
    //$colorIndividual->mutateProperties();
    //$output .= '<a href="/colour_evolution_interactive/' . $colorIndividual->getObject()->getHex() . '">' . $colorIndividual->render('html') . '</a>';
  //}

  $output .= '<p>Colour<pre>'.print_r($color, true).'</pre></p>';

  return $app['twig']->render('main.twig', array(
    'output' => $output,
    'styles' => $styles,
  ));
})
  ->value("color", '');




$app->run();

