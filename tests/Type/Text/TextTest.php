<?php

namespace Hashbangcode\Wevolution\Test\Type\Text;

use Hashbangcode\Wevolution\Type\Text\Text;

/**
 * Test class for Color
 */
class TextTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateText()
    {
        $object = new Text('fhsdlakjfhalksjdfhl');
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Text\Text', $object);
    }

    public function testRenderText()
    {
        $text = 'fhsdlakjfhalksjdfhl';
        $object = new Text($text);
        $this->assertEquals($text, $object->render());
    }
}
