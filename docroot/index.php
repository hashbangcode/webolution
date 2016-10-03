<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;
use Hashbangcode\Wevolution\Type\Color\Color;

date_default_timezone_set('Europe/London');
define('WEVOLUTION_INDIVIDUALS_PER_GENERATION', 10);
define('WEVOLUTION_MAX_GENERATIONS', 450);

require_once __DIR__ . '/../vendor/autoload.php';


set_error_handler("myErrorHandler");

$app = new Silex\Application();

// Register TWIG
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__ . '/views',
));

$app['debug'] = TRUE;

$app->get('/', function () {
  $output = 'Hi';

  $output .= '<p><a href="/number_evolution">Number Evolution</a></p>';
  $output .= '<p><a href="/color_evolution">Color Evolution</a></p>';
  $output .= '<p><a href="/colour_evolution_interactive">Color Evolution Interactive</a></p>';

  return $output;
});

$app->get('/number_evolution', function () use ($app) {
  $output = '';

  $styles = '';

  $output .= '<h1>Number Evolution Test</h1>';

  $population = new NumberPopulation();
  $population->setDefaultRenderType('html');

  for ($i = 0; $i < WEVOLUTION_INDIVIDUALS_PER_GENERATION; $i++) {
    $population->addIndividual(new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual(1));
  }

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

  return $app['twig']->render('main.twig', array(
    'output' => $output,
    'styles' => $styles,
  ));
});


$app->get('/color_evolution', function () use ($app) {
  $styles = '<style>div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}</style>';

  $output = '<h1>Color Evolution Test</h1>';

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

  return $app['twig']->render('main.twig', array(
    'output' => $output,
    'styles' => $styles,
  ));
});


$app->get('/colour_evolution_interactive/{color}', function ($color) use ($app) {

  $output = '<h1>Evolution Test</h1>';

  $styles = '<style>
span {width:30px;height:30px;display:inline-block;padding:0px;margin:-2px;}
a, a:link, a:visited, a:hover, a:active {padding:0px;margin:0px;}
img {padding:0px;margin:0px;}
</style>';

  $population = new ColorPopulation();
  $population->setDefaultRenderType('html');

  if ($color == '') {
    $colorObject = \Hashbangcode\Wevolution\Type\Color\Color::generateFromHex('000000');
  }
  else {
    $colorObject = \Hashbangcode\Wevolution\Type\Color\Color::generateFromHex($color);
    $output .= '<p><a href="/colour_evolution_interactive">Reset</a></a>';
  }

  $colorIndividual = new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual($colorObject->getRed(), $colorObject->getGreen(), $colorObject->getBlue());

  $population->addIndividual($colorIndividual);

  $evolution = new Evolution($population);

  $evolution->setGlobalMutationFactor(15);
  $evolution->setIndividualsPerGeneration(1000);

  // Run one generation.
  $evolution->runGeneration(FALSE);

  $colorPopulation = $evolution->getCurrentPopulation();

  $colorPopulation->sort('hue');

  $output .= '<p>' . PHP_EOL;

  foreach ($colorPopulation->getIndividuals() as $individual) {
    $output .= '<a href="/colour_evolution_interactive/' . $individual->getObject()->getHex() . '">' . $individual->render('html') . '</a>' . PHP_EOL;
  }
  $output .= '</p>';

  $output .= '<p>Colour<pre>' . print_r($color, TRUE) . '</pre></p>';

  return $app['twig']->render('main.twig', array(
    'output' => $output,
    'styles' => $styles,
  ));
})
  ->value("color", '');


$app->run();


function myErrorHandler($errno, $errstr, $errfile, $errline) {
  if (!(error_reporting() & $errno)) {
    // This error code is not included in error_reporting
    return;
  }

  switch ($errno) {
    case E_USER_ERROR:
      echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
      echo "  Fatal error on line $errline in file $errfile";
      echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
      echo "Aborting...<br />\n";
      exit(1);
      break;

    case E_USER_WARNING:
      echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
      echo "On line $errline in file $errfile<br>\n";
      exit(1);
      break;

    case E_USER_NOTICE:
      echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
      echo "On line $errline in file $errfile<br>\n";
      exit(1);
      break;

    default:
      echo "Unknown error type: [$errno] $errstr<br />\n";
      echo "On line $errline in file $errfile<br>\n";
      exit(1);
      break;
  }

  /* Don't execute PHP internal error handler */
  return TRUE;
}