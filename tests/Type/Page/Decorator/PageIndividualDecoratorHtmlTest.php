<?php

namespace Hashbangcode\Webolution\Test\Type\Page\Decorator;

use Hashbangcode\Webolution\Type\Page\Decorator\PageIndividualDecoratorHtml;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class PageIndividualDecoratorHtmlTest extends TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PageIndividual');
        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Page\Decorator\PageIndividualDecoratorHtml', $individualDecorator);
    }

    public function testSimplePageCreation()
    {
        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([]);
        $page->getBody()->willReturn(null);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $output = $individualDecorator->render();
        $this->assertStringEqualsFile(__DIR__ . '/data/page01.html', $output);
    }

    public function testPageCreationWithBody()
    {
        $body = new \Hashbangcode\Webolution\Type\Element\Element();

        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([]);
        $page->getBody()->willReturn($body);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $output = $individualDecorator->render();

        $this->assertStringEqualsFile(__DIR__ . '/data/page02.html', $output);
    }

    public function testPageCreationWithBodyAndStyle()
    {
        $body = new \Hashbangcode\Webolution\Type\Element\Element();

        $style = new \Hashbangcode\Webolution\Type\Style\Style('div.test', ['color' => 'red']);

        $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $page->getStyles()->willReturn([$style]);
        $page->getBody()->willReturn($body);

        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PageIndividual');
        $individual->getObject()->willReturn($page);

        $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
        $output = $individualDecorator->render();

        $this->assertStringEqualsFile(__DIR__ . '/data/page03.html', $output);
    }

  public function testPageCreationWithBodyAndStyleWithColorObject()
  {
    $body = new \Hashbangcode\Webolution\Type\Element\Element();

    $color = \Hashbangcode\Webolution\Type\Color\ColorIndividual::generateFromHex('2CA02C');

    $style = new \Hashbangcode\Webolution\Type\Style\Style('div.test', ['color' => $color]);

    $page = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
    $page->getStyles()->willReturn([$style]);
    $page->getBody()->willReturn($body);

    $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PageIndividual');
    $individual->getObject()->willReturn($page);

    $individualDecorator = new PageIndividualDecoratorHtml($individual->reveal());
    $output = $individualDecorator->render();

    $this->assertStringEqualsFile(__DIR__ . '/data/page04.html', $output);
  }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
