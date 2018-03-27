<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\PageIndividualDecoratorHtml;
use Prophecy\Prophet;

class PageIndividualDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual');
        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\PageIndividualDecoratorHtml', $individualDecorator);
    }

    public function testSimplePageCreation()
    {
        $page = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Page\Page');
        $page->getStyles()->willReturn([]);
        $page->getBody()->willReturn(null);

        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $output = $individualDecorator->render();
        $this->assertStringEqualsFile('tests/Evolution/Individual/Decorators/data/page01.html', $output);
    }

    public function testPageCreationWithBody()
    {
        $body = new \Hashbangcode\Wevolution\Type\Element\Element();

        $page = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Page\Page');
        $page->getStyles()->willReturn([]);
        $page->getBody()->willReturn($body);

        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $output = $individualDecorator->render();

        $this->assertStringEqualsFile('tests/Evolution/Individual/Decorators/data/page02.html', $output);
    }

    public function testPageCreationWithBodyAndStyle()
    {
        $body = new \Hashbangcode\Wevolution\Type\Element\Element();

        $style = new \Hashbangcode\Wevolution\Type\Style\Style('div.test', ['color' => 'red']);

        $page = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Page\Page');
        $page->getStyles()->willReturn([$style]);
        $page->getBody()->willReturn($body);

        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $output = $individualDecorator->render();

        $this->assertStringEqualsFile('tests/Evolution/Individual/Decorators/data/page03.html', $output);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
