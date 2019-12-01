<?php

namespace Hashbangcode\Webolution\Test\Type\Text;

use Hashbangcode\Webolution\Type\Text\Text;
use Hashbangcode\Webolution\Type\Text\TextFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test class for TextFactory.
 */
class TextFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $object = TextFactory::generateRandom();
        $this->assertInstanceOf(Text::class, $object);
        $this->assertEquals(10, strlen($object->getText()));
    }
}
