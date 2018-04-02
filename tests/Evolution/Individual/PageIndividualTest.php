<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Wevolution\Type\Page\Page;

/**
 * Test class for PageIndividual
 */
class PageIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = new PageIndividual(new Page());
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual', $object);
    }
}
