<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Wevolution\Evolution\Population\PagePopulation;

$app->get('/page_evolution_storage[/{evolutionid}]', function ($request, $response, $args) {
    $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}.elementframe{width:500px;height:500px;}';

    $title = 'Page Storage Test';

    $population = new PagePopulation();

    $population->setDefaultRenderType('htmlfull');

    // Setup evolution storage.
    $database = realpath(__DIR__ . '/../../database') . '/database.sqlite';
    $evolution = new EvolutionStorage();

    $evolution->setEvolutionId(4);

    $evolution->setupDatabase('sqlite:' . $database);

    $evolution->setIndividualsPerGeneration(10);

    // Get generation.
    $generation = $evolution->getGeneration();

    if ($generation == 1) {
        $pageIndividual = new PageIndividual();

        $p = new ElementIndividual('p');
        $ul = new Element('ul');
        $li = new Element('li');

        $p->getObject()->addChild($ul);
        $ul->addChild($li);

        $pageIndividual->getObject()->setBody($p);

        $style_object = new StyleIndividual('.text');
        $pageIndividual->getObject()->setStyle($style_object);

        $population->addIndividual($pageIndividual);

        $evolution->setPopulation($population);
    } else {
        $evolution->setPopulation($population);
        $evolution->loadPopulation();
    }

    // Run generation.
    $evolution->runGeneration();

    $output = '';

    $output .= '<p>Generation: ' . $evolution->getGeneration() . '</p>';

    $output .= $evolution->renderGenerations();

    return $this->view->render($response, 'demos.twig', [
        'title' => $title,
        'output' => $output,
        'styles' => $styles
    ]);
});
