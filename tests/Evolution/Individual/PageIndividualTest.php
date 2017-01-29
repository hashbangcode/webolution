<?php

use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;

/**
 * Test class for PageIndividual
 */
class PageIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateIndividual() {
    $object = new PageIndividual();
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual', $object);
  }

}
