<?php

namespace Hashbangcode\Webolution\Test\Type\Unit;

use Hashbangcode\Webolution\Type\Unit\Unit;
use Hashbangcode\Webolution\Type\Unit\UnitFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test class for UnitFactory.
 */
class UnitFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $object = UnitFactory::generateRandom();
        $this->assertInstanceOf(Unit::class, $object);
    }
}
