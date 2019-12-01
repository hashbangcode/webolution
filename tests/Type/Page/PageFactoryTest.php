<?php

namespace Hashbangcode\Webolution\Test\Type\Page;

use Hashbangcode\Webolution\Type\Page\Page;
use Hashbangcode\Webolution\Type\Page\PageFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test class for PageFactory.
 */
class PageFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $object = PageFactory::generateRandom();
        $this->assertInstanceOf(Page::class, $object);
    }
}
