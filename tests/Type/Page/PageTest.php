<?php

use Hashbangcode\Wevolution\Type\Page\Page;

/**
 * Test class for Page
 */
class PageTest extends PHPUnit_Framework_TestCase
{

  public function testCreateImage() {
    $object = new Page();
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Page\Page', $object);
  }
}
