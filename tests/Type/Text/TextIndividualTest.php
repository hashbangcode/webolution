<?php

namespace Hashbangcode\Webolution\Test\Type\Text;

use Hashbangcode\Webolution\Type\Text\TextIndividual;
use PHPUnit\Framework\TestCase;

class TextIndividualTest extends TestCase
{
    public function testCreateIndividual()
    {
        $object = TextIndividual::generateRandomTextIndividual(1);
        $this->assertEquals(36, strlen($object->getId()));
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\TextIndividual', $object);
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
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\TextIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\Text', $object->getObject());
        $text = $object->getObject()->getText();
        $this->assertEquals(10, strlen($text));
    }

    public function testGenerateRandomTextWithArguments()
    {
        $object = TextIndividual::generateRandomTextIndividual(20);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\TextIndividual', $object);
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

        $this->assertEquals('abc', $object->getName());
        $this->assertEquals('891568578', $object->getSpecies());

        $this->assertEquals('abc', $object->getObject()->getText());
        $object->mutate();
        $this->assertNotEquals('abc', $object->getObject()->getText());
    }
}
