<?php

namespace Hashbangcode\Wevolution\Demos\Controller;

use Hashbangcode\Wevolution\Demos\Controller\BaseController;
use Hashbangcode\Wevolution\Evolution\EvolutionManager;
use Slim\Http\Request;
use Slim\Http\Response;
use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

class NumberController extends BaseController
{

    public function numberEvolution(Request $request, Response $response, $args)
    {
        $this->logger->info("Number Eovolution '/number_evolution' route");

        $title = 'Number Evolution Test';

        // Setup the population.
        $population = new NumberPopulation();
        $population->setDefaultRenderType('html');

        // Add individuals to the population.
        for ($i = 0; $i < 30; $i++) {
            $population->addIndividual(new NumberIndividual(1));
        }

        // Create the EvolutionManager object and add the population to it.
        $evolution = new EvolutionManager();
        $evolution->getEvolutionObject()->setPopulation($population);
        $evolution->runEvolution();

        $output = '';
        $output .= $evolution->getEvolutionObject()->renderGenerations();

        return $this->view->render($response, 'demos.twig', [
            'title' => $title,
            'output' => $output
        ]);
    }
}
