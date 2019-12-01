<?php

namespace Hashbangcode\Webolution\Test\Type\Element;

use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Element\ElementFactory;
use PHPUnit\Framework\TestCase;

class ElementFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $object = ElementFactory::generateRandom();
        $this->assertInstanceOf(Element::class, $object);
    }

    /**
     * @dataProvider htmlStringDataProvider
     */
    public function testCreateElementsFromStrings($string, $parentElement, $numberOfElements)
    {
        $element = ElementFactory::generateFromString($string);
        $this->assertEquals($parentElement, $element->getType());
        $this->assertEquals($numberOfElements, count($element->getAllElements()));
    }

    /**
     * Data provider for htmlStringDataProvider.
     *
     * @return array
     *   The test data.
     */
    public function htmlStringDataProvider()
    {
        return [
            ['<div></div>', 'div', 1],
            ['<div></div><div></div>', 'div', 2],
            ['<p></p>', 'p', 1],
            ['<p>Text</p>', 'p', 1],
            ['<div><p>Text</p></div>', 'div', 2],
            ['<div><div><p>Text</p></div></div>', 'div', 3],
            ['<div><div><div><p>Text</p></div></div></div>', 'div', 4],
            ['<div><div></div><div></div><div></div></div>', 'div', 4],
        ];
    }
}