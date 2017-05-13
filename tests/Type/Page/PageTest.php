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
        $this->assertStringEqualsFile('tests/Type/Page/page01.html', $output);
    }

    public function testRenderPageWithBody()
    {
        $object = new Page();

        $body = new Element('div');
        $object->setBody($body);

        $output = $object->render();
        $this->assertStringEqualsFile('tests/Type/Page/page02.html', $output);
    }

    public function testRenderPageWithStyle()
    {
        $object = new Page();

        $style = new Style('div');
        $style->setAttrbute('color', 'red');
        $object->setStyle($style);

        $output = $object->render();
        $this->assertStringEqualsFile('tests/Type/Page/page03.html', $output);
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
        $this->assertStringEqualsFile('tests/Type/Page/page04.html', $output);
    }

    public function testGetAndSetStyles()
    {
        $object = new Page();

        $style = new Style('div');
        $style->setAttrbute('color', 'red');
        $styles = [$style];
        $object->setStyles($styles);

        $body = new Element('div');
        $object->setBody($body);

        $output = $object->render();
        $this->assertStringEqualsFile('tests/Type/Page/page04.html', $output);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getStyle('div'));
    }

    public function testGetNonExistantStyle()
    {
        $object = new Page();

        $style = new Style('div');
        $style->setAttrbute('color', 'red');
        $styles = [$style];
        $object->setStyles($styles);

        $body = new Element('div');
        $object->setBody($body);

        $this->assertFalse($object->getStyle('something'));
    }
}
