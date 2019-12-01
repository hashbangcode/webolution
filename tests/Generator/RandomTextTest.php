<?php

namespace Hashbangcode\Webolution\Test\Generator;

use Hashbangcode\Webolution\Generator\RandomText;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Color
 */
class RandomTextTest extends TestCase
{
    use RandomText;

    public function testCreateLetter()
    {
        $letter = $this->getRandomLetter();
        $this->assertTrue(is_string($letter));
        $this->assertEquals(1, strlen($letter));
    }

    public function testCreateText()
    {
        $letter = $this->generateRandomText();
        $this->assertTrue(is_string($letter));
        $this->assertEquals(7, strlen($letter));
    }
}
