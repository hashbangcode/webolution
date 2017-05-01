<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ImagePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual;

$app->get('/image_evolution', function ($request, $response, $args) {

    $this->logger->info("Image Eovolution '/image_evolution' route");

    $title = 'Image Evolution Test';

    $styles = "img{border:1px solid black;}";

    $population = new ImagePopulation();
    $population->setDefaultRenderType('image');

    for ($i = 0; $i < 10; $i++) {
        $population->addIndividual(new ImageIndividual(10, 10));
    }

    $evolution = new Evolution($population);
    $evolution->setIndividualsPerGeneration(10);
    $evolution->setMaxGenerations(100);
    $evolution->setAllowedFitness(1);
    $evolution->setGlobalMutationFactor(1);

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
