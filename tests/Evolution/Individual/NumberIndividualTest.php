<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

/**
 * Test class for ColorIndividual
 */
class NumberIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = new NumberIndividual(1);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Number\Number', $object->getObject());
    }

    public function testMutateNumberThroughIndividual()
    {
        $object = new NumberIndividual(1);
        $object->setMutationFactor(1);
        $object->mutateProperties();
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testMutateNumberThroughIndividualWithDifferentFactor()
    {
        $object = new NumberIndividual(1);
        $object->setMutationFactor(2);
        $object->mutateProperties();
        $this->assertNotEquals(1, $object->getObject()->getNumber());
        $this->assertEquals(2, $object->getMutationFactor());
    }

    public function testGetFitness()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals(1, $object->getFitness());
        $object->getObject()->setNumber(8);
        $this->assertEquals(8, $object->getFitness());
    }

    public function testCliRender()
    {
        $object = new NumberIndividual(1);
        $renderType = 'cli';
        $this->assertEquals('1 ', $object->render($renderType));
    }

    public function testHtmlRender()
    {
        $object = new NumberIndividual(1);
        $renderType = 'html';
        $this->assertEquals('1 ', $object->render($renderType));
    }

    public function testDefaultRender()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals('1 ', $object->render());
    }

    public function testMutateNumber()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutateNumber();
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testMutateZeroNumber()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutateNumber(0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutateNumber(0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutateNumber(0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutateNumber(0);
        $this->assertEquals(1, $object->getObject()->getNumber());
    }
}
