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

    public function testGetText()
    {
        $text = 'fhsdlakjfhalksjdfhl';
        $object = new Text($text);
        $this->assertEquals($text, $object->getText());
    }

    public function testSetAndGetText()
    {
        $text = 'fhsdlakjfhalksjdfhl';
        $object = new Text($text);

        $otheText = 'fsda89f670das9 fbds8 7yf8s7df';
        $object->setText($otheText);
        $this->assertEquals($otheText, $object->getText());
    }
}
