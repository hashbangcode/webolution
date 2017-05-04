<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Population\ImagePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual;

$app->get('/image_evolution', function ($request, $response, $args) {

    $this->logger->info("Image Eovolution '/image_evolution' route");

    $title = 'Image Evolution Test';

    $styles = "img{border:1px solid black;}";

    $population = new ImagePopulation();
    $population->setDefaultRenderType('image');

    for ($i = 0; $i < 10; $i++) {
        $image = new ImageIndividual(25, 25);
        $image->getObject()->setPixel(24, 12, 1);
        $population->addIndividual($image);
    }

    $evolution = new Evolution($population);
    $evolution->setIndividualsPerGeneration(10);
    $evolution->setMaxGenerations(300);

    $output = '';

    for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
        if ($evolution->runGeneration() === false) {
            $output .= '<p>Everyone is dead.</p>';
            break;
        }
    }

    $output .= $evolution->renderGenerations();

    return $this->view->render($response, 'demos.twig', [
        'title' => $title,
        'output' => $output,
        'styles' => $styles,
    ]);
});

$app->get('/image_evolution_storage[/{evolutionid}]', function ($request, $response, $args) {

    $title = 'Image Evolution Database Test';

    $styles = 'img{border:1px solid black;} span {width:30px;height:30px;display:inline-block;padding:0px;margin:-2px;}
a, a:link, a:visited, a:hover, a:active {padding:0px;margin:0px;}';

    $database = realpath(__DIR__ . '/../../database') . '/database.sqlite';
    $evolution = new EvolutionStorage();

    $evolution->setEvolutionId(1);

    $evolution->setupDatabase('sqlite:' . $database);

    $evolution->setIndividualsPerGeneration(100);

    $generation = $evolution->getGeneration();

    $population = new ImagePopulation();
    $population->setDefaultRenderType('image');

    if ($generation == 1) {
        for ($i = 0; $i < 10; $i++) {
            $image = new ImageIndividual(25, 25);
            $image->getObject()->setPixel(24, 12, 1);
            $population->addIndividual($image);
        }

        $evolution->setPopulation($population);
    } else {
        $evolution->setPopulation($population);
        $evolution->loadPopulation();
    }

    $evolution->runGeneration();

    $output = '';

    $output .= '<p>Generation: ' . $evolution->getGeneration() . '</p>';


    $population = $evolution->getCurrentPopulation();

    //$population->sort();

    $output .= '<p>';

    foreach ($population->getIndividuals() as $individual) {
        $output .= '<a href="/image_evolution_storage/' . $individual->getObject()->getPixel(0,0) . '">' . $individual->render('image') . '</a>' . PHP_EOL;
    }
    $output .= '</p>';

    //$output .= nl2br($evolution->renderGenerations());

    return $this->view->render($response, 'demos.twig', [
        'title' => $title,
        'output' => $output,
        'styles' => $styles,
        'meta' => '<meta http-equiv="refresh" content="5" >',
    ]);
});
