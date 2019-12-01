<?php

namespace Hashbangcode\Webolution\Test\Type\Number;

use Hashbangcode\Webolution\Type\Number\Number;
use Hashbangcode\Webolution\Type\Number\NumberFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test class for NumberFactory.
 */
class NumberFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $object = NumberFactory::generateRandom();
        $this->assertInstanceOf(Number::class, $object);
    }
}
