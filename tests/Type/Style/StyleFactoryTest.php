<?php

namespace Hashbangcode\Webolution\Test\Type\Style;

use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Type\Style\StyleFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test class for StyleFactory.
 */
class StyleFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $object = StyleFactory::generateRandom();
        $this->assertInstanceOf(Style::class, $object);
    }
}
