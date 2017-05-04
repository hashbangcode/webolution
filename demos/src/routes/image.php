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
        $image = new ImageIndividual(25, 25);
        $image->getObject()->setPixel(24, 12, 1);
        $population->addIndividual($image);
    }

    $evolution = new Evolution($population);
    $evolution->setIndividualsPerGeneration(10);
    $evolution->setMaxGenerations(300);
    $evolution->setGlobalMutationFactor(-25);

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
