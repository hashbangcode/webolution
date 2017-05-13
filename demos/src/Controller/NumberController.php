<?php

namespace Hashbangcode\Wevolution\Demos\Controller;

use Hashbangcode\Wevolution\Demos\Controller\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;
use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

class NumberController extends BaseController
{

    public function numberEvolution(Request $request, Response $response, $args)
    {
        $this->logger->info("Number Eovolution '/number_evolution' route");

        $title = 'Number Evolution Test';

        $population = new NumberPopulation();
        $population->setDefaultRenderType('html');

        for ($i = 0; $i < 30; $i++) {
            $population->addIndividual(new NumberIndividual(1));
        }

        $evolution = new Evolution($population);
        $evolution->setIndividualsPerGeneration(30);
        $evolution->setMaxGenerations(500);
        $evolution->setAllowedFitness(1);
        $evolution->setGlobalMutationFactor(1);
        $evolution->setGlobalMutationAmount(1);

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
            'output' => $output
        ]);
    }
}
