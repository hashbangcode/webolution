<?php

namespace Hashbangcode\Webolution\Test\Type\Page;

use Hashbangcode\Webolution\Type\Page\PageIndividual;
use Hashbangcode\Webolution\Type\Page\Page;
use PHPUnit\Framework\TestCase;

/**
 * Test class for PageIndividual
 */
class PageIndividualTest extends TestCase
{

    public function testCreateIndividual()
    {
        $object = new PageIndividual(new Page());
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Page\PageIndividual', $object);
    }
}
