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
        $this->assertEquals(10, strlen($letter));
    }

    public function testGenerateFakeTitle()
    {
        $title = $this->generateFakeTitle();
        $this->assertTrue(is_string($title));
        $this->assertGreaterThan(1, strlen($title));
        $this->assertLessThan(15, strlen($title));
    }

    public function testGenerateFakeText()
    {
        $text = $this->generateFakeText();
        $this->assertTrue(is_string($text));
        $this->assertGreaterThan(1, strlen($text));
        $this->assertLessThan(300, strlen($text));
    }
}
