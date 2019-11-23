<?php

namespace Hashbangcode\Webolution\Test\Type\Page;

use Hashbangcode\Webolution\Type\Page\Page;
use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Type\Element\Element;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Page
 */
class PageTest extends TestCase
{
    public function testGetAndSetStyles()
    {
        $object = new Page();

        $style = new Style('div');
        $style->setAttribute('color', 'red');
        $styles = [$style];
        $object->setStyles($styles);

        $element = new Element('div');
        $object->setBody($element);

        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Style\Style', $object->getStyle('div'));
    }

    public function testGetNonExistantStyle()
    {
        $object = new Page();

        $style = new Style('div');
        $style->setAttribute('color', 'red');
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

    public function testClonePage()
    {
        $object = new Page();
        $element = new Element('div');
        $element->setAttribute('class', 'wibble');
        $object->setBody($element);
        $object->setStyle(new Style('div', ['color' => 'black']));

        $clone = clone $object;
        // Altering a class on this object should not change the previous object.
        $clone->getBody()->setAttribute('class', 'monkey');
        $this->assertEquals('wibble', $object->getBody()->getAttribute('class'));

        // Altering a style should not change the previous object.
        $cloneStyles = $clone->getStyles();
        $cloneStyles['div']->setAttribute('color', 'red');
        $styles = $object->getStyles();
        $this->assertEquals('black', $styles['div']->getAttribute('color'));
    }

    public function testAddSimilarStyles()
    {
        $object = new Page();
        $object->setStyle(new Style('div', ['color' => 'black']));
        $object->setStyle(new Style('div', ['color' => 'red']));
        $this->assertEquals('red', $object->getStyles()['div']->getAttribute('color'));
    }

    public function testGenerateStylesFromBody()
    {
        $object = new Page();

        $element = new Element('div');
        $inner_element = new Element('p');
        $inner_element->setAttribute('class', 'paragraph');
        $element->addChild($inner_element);
        $object->setBody($element);

        $object->generateStylesFromBody();

        $styles = $object->getStyles();
        $this->assertTrue(isset($styles['div']));
        $this->assertTrue(isset($styles['p.paragraph']));
    }

    public function testPurgeStylesWithoutElements()
    {
        $object = new Page();

        $element = new Element('div');
        $inner_element = new Element('p');
        $inner_element->setAttribute('class', 'paragraph');
        $element->addChild($inner_element);

        $object->setBody($element);

        $object->generateStylesFromBody();

        $object->setStyle(new Style('h1'));
        $object->setStyle(new Style('h2'));
        $object->setStyle(new Style('h3'));
        $object->setStyle(new Style('h4'));
        $object->setStyle(new Style('p.wibble'));

        $object->purgeStylesWithoutElements();

        $styles = $object->getStyles();

        $this->assertTrue(isset($styles['div']));
        $this->assertTrue(isset($styles['p.paragraph']));
        $this->assertFalse(isset($styles['h1']));
        $this->assertFalse(isset($styles['h2']));
        $this->assertFalse(isset($styles['h3']));
    }
}
