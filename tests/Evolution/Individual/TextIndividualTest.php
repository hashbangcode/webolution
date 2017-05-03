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
        $object = new TextIndividual(1);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Text\Text', $object->getObject());
    }

    public function testMutateTextThroughIndividual()
    {
        $object = new TextIndividual(1);
        $object->setMutationFactor(1);
        $object->mutate();
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
        $object = new TextIndividual(1);
        $object->setMutationFactor(2);
        $object->mutate();
        $this->assertNotEquals(1, $object->getObject()->getText());
        $this->assertEquals(2, $object->getMutationFactor());
    }

    public function testGetFitness()
    {
        $object = new TextIndividual(1);
        $this->assertEquals(0, $object->getFitness());
    }

    public function testGetFitnessWithGoal()
    {
        $object = new TextIndividual(1);
        $object->setFitnessGoal(1);
        $this->assertEquals(1, $object->getFitness());
    }

    public function testCliRender()
    {
        $object = new TextIndividual(1);
        $renderType = 'cli';
        $this->assertEquals('1 ', $object->render($renderType));
    }

    public function testHtmlRender()
    {
        $object = new TextIndividual(1);
        $renderType = 'html';
        $this->assertEquals('1<br>', $object->render($renderType));
    }

    public function testDefaultRender()
    {
        $object = new TextIndividual(1);
        $this->assertEquals('1 ', $object->render());
    }

    public function testmutateText()
    {
        $object = new TextIndividual(1);
        $this->assertEquals(1, $object->getObject()->getText());
        $object->mutate();
        $this->assertNotEquals(1, $object->getObject()->getText());
    }
}
