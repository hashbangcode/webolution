<?php

namespace Hashbangcode\Webolution\Test\Type\Text;

use Hashbangcode\Webolution\Type\Text\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
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
