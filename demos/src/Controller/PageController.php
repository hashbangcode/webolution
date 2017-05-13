<?php

namespace Hashbangcode\Wevolution\Demos\Controller;

use Hashbangcode\Wevolution\Demos\Controller\BaseController;
use Hashbangcode\Wevolution\Evolution\Population\StylePopulation;
use Slim\Http\Request;
use Slim\Http\Response;
use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Wevolution\Evolution\Population\PagePopulation;

class PageController extends BaseController
{

    public function page(Request $request, Response $response, $args)
    {
        $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}.elementframe{width:500px;height:500px;}';

        $title = 'Page Test';

        $output = '';

        $page = new PageIndividual();

        $style = new Style('div');
        $style->setAttrbute('font-size', '20px');
        $page->getObject()->setStyle($style);

        $body = new Element('div');
        $p = new Element('p');
        $body->addChild($p);

        $page->getObject()->setBody($body);

        $pageHtml = $page->render('html');

        $output .= '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $pageHtml . '\'></iframe>';
        $output .= '<textarea rows="35" cols="35">' . $pageHtml . '</textarea>';

        return $this->view->render($response, 'demos.twig', [
            'title' => $title,
            'output' => $output,
            'styles' => $styles
        ]);
    }

    public function pageEvolution(Request $request, Response $response, $args)
    {
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
    }
}
