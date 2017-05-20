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

        $element = new Element('div');
        $object->setBody($element);

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

        $element = new Element('div');
        $object->setBody($element);

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

        $element = new Element('div');
        $object->setBody($element);

        $this->assertFalse($object->getStyle('something'));
    }

    public function testGetAllSelectors()
    {
        $object = new Page();

        $element = new Element('div');
        $inner_element = new Element('p');
        $inner_element->setAttribute('class', 'paragraph');
        $element->addChild($inner_element);
        $object->setBody($element);

        // The page and body elements should both produce the same selectors list.
        $page_selectors = $object->getSeletors();
        $element_selectors = $element->getAllSelectors();
        $this->assertEquals($page_selectors, $element_selectors);
    }

    public function testGetAllTypes()
    {
        $object = new Page();

        $element = new Element('div');
        $inner_element = new Element('p');
        $inner_element->setAttribute('class', 'paragraph');
        $element->addChild($inner_element);
        $object->setBody($element);

        // The page and body elements should both produce the same selectors list.
        $page_selectors = $object->getBodyElementTypes();
        $element_selectors = $element->getAllTypes();
        $this->assertEquals($page_selectors, $element_selectors);
    }

    public function testGetAllClasses()
    {
        $object = new Page();

        $element = new Element('div');
        $inner_element = new Element('p');
        $inner_element->setAttribute('class', 'paragraph');
        $element->addChild($inner_element);
        $object->setBody($element);

        // The page and body elements should both produce the same selectors list.
        $page_selectors = $object->getBodyClasses();
        $element_selectors = $element->getAllClasses();
        $this->assertEquals($page_selectors, $element_selectors);
    }
}
