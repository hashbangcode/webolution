<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\TextIndividual;

/**
 * Test class for ColorIndividual
 */
class TextIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = TextIndividual::generateRandomTextIndividual(1);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Text\Text', $object->getObject());
    }

    public function testMutateTextThroughIndividual()
    {
        $object = TextIndividual::generateRandomTextIndividual(1);
        $object->mutate(1);
        $this->assertNotEquals(1, $object->getObject()->getText());
    }

    public function testGenerateRandomText()
    {
        $object = TextIndividual::generateRandomTextIndividual();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Text\Text', $object->getObject());
        $text = $object->getObject()->getText();
        $this->assertEquals(7, strlen($text));
    }

    public function testGenerateRandomTextWithArguments()
    {
        $object = TextIndividual::generateRandomTextIndividual(20);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Text\Text', $object->getObject());
        $text = $object->getObject()->getText();
        $this->assertEquals(20, strlen($text));
    }

    public function testMutateTextThroughIndividualWithDifferentFactor()
    {
        $object = TextIndividual::generateRandomTextIndividual(1);
        $object->mutate(2);
        $this->assertNotEquals(1, $object->getObject()->getText());
    }

    public function testGetFitness()
    {
        $object = TextIndividual::generateRandomTextIndividual(1);
        $this->assertEquals(0, $object->getFitness());
    }

    public function testGetFitnessWithGoal()
    {
        $object = TextIndividual::generateRandomTextIndividual('abc');
        $object->setFitnessGoal('abc');
        $this->assertEquals(0, $object->getFitness());
    }

    public function testCliRender()
    {
        $object = TextIndividual::generateFromString('abc');
        $renderType = 'cli';
        $this->assertEquals('abc ', $object->render($renderType));
    }

    public function testHtmlRender()
    {
        $object = TextIndividual::generateFromString('abc');
        $renderType = 'html';
        $this->assertEquals('abc<br>', $object->render($renderType));
    }

    public function testDefaultRender()
    {
        $object = TextIndividual::generateFromString('abc');
        $this->assertEquals('abc ', $object->render());
    }

    public function testmutateText()
    {
        $object = TextIndividual::generateFromString('abc');
        $this->assertEquals('abc', $object->getObject()->getText());
        $object->mutate();
        $this->assertNotEquals('abc', $object->getObject()->getText());
    }
}
