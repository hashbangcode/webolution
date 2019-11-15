<?php

namespace Hashbangcode\Webolution\Test\Individual;

use Hashbangcode\Webolution\Type\Page\PageIndividual;
use Hashbangcode\Webolution\Type\Page\Page;

/**
 * Test class for PageIndividual
 */
class PageIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = new PageIndividual(new Page());
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Page\PageIndividual', $object);
    }
}
