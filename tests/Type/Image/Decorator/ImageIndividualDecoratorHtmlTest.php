<?php

namespace Hashbangcode\Webolution\Test\Type\Image\Decorator;

use Hashbangcode\Webolution\Type\Image\Decorator\ImageIndividualDecoratorHtml;
use Prophecy\Prophet;

class ImageIndividualDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $individualDecorator = new ImageIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Image\Decorator\ImageIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\Image');

        $imageMatrix = array_fill_keys(range(0, 9), 0);
        foreach ($imageMatrix as $id => $imagePart) {
            $imageMatrix[$id] = array_fill_keys(range(0, 9), 0);
        }

        $object->getImageMatrix()->willReturn($imageMatrix);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ImageIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        // Test that the rendered image is +100 the original array size.
        $this->assertContains('width="110"', $render);
        $this->assertContains('height="110"', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
