<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual;

use Hashbangcode\Webolution\Evolution\Individual\TextIndividual;

/**
 * Test class for ColorIndividual
 */
class TextIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = TextIndividual::generateRandomTextIndividual(1);
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\Text', $object->getObject());
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
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\Text', $object->getObject());
        $text = $object->getObject()->getText();
        $this->assertEquals(7, strlen($text));
    }

    public function testGenerateRandomTextWithArguments()
    {
        $object = TextIndividual::generateRandomTextIndividual(20);
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\Text', $object->getObject());
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

    public function testmutateText()
    {
        $object = TextIndividual::generateFromString('abc');
        $this->assertEquals('abc', $object->getObject()->getText());
        $object->mutate();
        $this->assertNotEquals('abc', $object->getObject()->getText());
    }
}
