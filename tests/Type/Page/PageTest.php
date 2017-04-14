<?php

namespace Hashbangcode\Wevolution\Test\Type\Page;

use Hashbangcode\Wevolution\Type\Page\Page;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Test class for Page
 */
class PageTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateObject()
    {
        $object = new Page();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Page\Page', $object);
    }

    public function testRenderSimplePage()
    {
        $object = new Page();
        $output = $object->render();

        $this->assertEquals($output, '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
    </body>
</html>');
    }

    public function testRenderPageWithBody()
    {
        $object = new Page();

        $body = new Element('div');
        $object->setBody($body);

        $output = $object->render();

        $this->assertEquals($output, '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
<div></div>
    </body>
</html>');
    }

    public function testRenderPageWithStyle()
    {
        $object = new Page();

        $style = new Style('div');
        $style->setAttrbute('color', 'red');
        $object->setStyle($style);

        $output = $object->render();

        $this->assertEquals($output, '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
<style>div{color:red;}</style>
    </head>
    <body>
    </body>
</html>');
    }

    public function testRenderPageWithBodyAndStyle()
    {
        $object = new Page();

        $style = new Style('div');
        $style->setAttrbute('color', 'red');
        $object->setStyle($style);

        $body = new Element('div');
        $object->setBody($body);

        $output = $object->render();

        $this->assertEquals($output, '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
<style>div{color:red;}</style>
    </head>
    <body>
<div></div>
    </body>
</html>');
    }
}
