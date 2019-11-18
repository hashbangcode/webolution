<?php

namespace Hashbangcode\Webolution\Test\Type\Element;

use Hashbangcode\Webolution\Type\Element\Element;
use Prophecy\Prophet;

/**
 * Test class for Color
 */
class ElementTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAttribute()
    {
        $object = new Element();
        $object->setType('div');
        $object->setAttributes(array('id' => 'test'));
        $this->assertEquals('test', $object->getAttribute('id'));
    }

    public function testGetInvalidAttribute()
    {
        $object = new Element();
        $object->setType('div');
        $object->setAttributes(array('id' => 'test'));
        $this->assertEquals(false, $object->getAttribute('monkey'));
    }

    public function testResetAttributes()
    {
        $object = new Element();
        $object->setType('div');
        $object->setAttributes(array('id' => 'test', 'class' => 'test'));
        $this->assertEquals('test', $object->getAttributes()['id']);
        $this->assertEquals(2, count($object->getAttributes()));
        $object->setAttributes(array('id' => 'another'));
        $this->assertEquals('another', $object->getAttributes()['id']);
        $this->assertEquals(1, count($object->getAttributes()));
    }

    public function testSetSingleAttribute()
    {
        $object = new Element();
        $object->setType('div');
        $object->setAttribute('id', 'test');
        $this->assertEquals('test', $object->getAttributes()['id']);
        $object->setAttribute('id', 'another');
        $this->assertEquals('another', $object->getAttributes()['id']);
    }

    public function testAddInvalidChild()
    {
        $outer_element = new Element();
        $outer_element->setType('ol');

        $inner_element = new Element();
        $inner_element->setType('div');

        $message = 'Cant add child of type "div" to "ol"';
        $this->setExpectedException('Hashbangcode\Webolution\Type\Element\Exception\InvalidChildTypeException', $message);
        $outer_element->addChild($inner_element);
    }

    public function testSetIncorrectAttributes()
    {
        $element = new Element();
        $element->setType('p');
        $this->setExpectedException('Hashbangcode\Webolution\Type\Element\Exception\InvalidAttributesException');
        $element->setAttributes(2);
    }

    public function testSetChildElement()
    {
        $element = new Element('ul');
        $child_types = $element->getAvailableChildTypes();
        $this->assertEquals('li', $child_types[0]);
    }

    /**
     * @dataProvider elementChildTypes
     */
    public function testGetAvailableChildTypes($type, $childTypes)
    {
        $element = new Element($type);
        $returnedChildTypes = $element->getAvailableChildTypes();

        foreach ($returnedChildTypes as $id => $childType) {
            $this->assertEquals($childTypes[$id], $returnedChildTypes[$id]);
        }
    }

    public function elementChildTypes()
    {
        return [
           ['type' => 'html', 'childTypes' => ['body']],
           ['type' => 'head', 'childTypes' => ['style']],
           ['type' => 'ul', 'childTypes' => ['li']],
           ['type' => 'ol', 'childTypes' => ['li']],
           ['type' => 'p', 'childTypes' => ['ul', 'ol', 'div', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'strong', 'em',]],
        ];
    }

    public function testCloneElement()
    {
        $element = new Element();
        $element->setType('div');

        $elementClone = clone $element;

        $elementClone->setType('p');
        $elementClone->setAttribute('class', 'wibble');

        $this->assertEquals('div', $element->getType());
        $this->assertEquals('p', $elementClone->getType());

        $this->assertEquals('wibble', $elementClone->getAttribute('class'));
    }

    public function testCloneElementWithChild()
    {
        $outerElement = new Element();
        $outerElement->setType('div');

        $innerElement = new Element();
        $innerElement->setType('div');

        $outerElement->addChild($innerElement);

        $elementClone = clone $outerElement;

        $elementClone->setType('p');
        $elementClone->setAttribute('class', 'wibble');
        $elementClone->getChildren()[0]->setAttribute('class', 'wobble');

        $this->assertEquals('div', $outerElement->getType());
        $this->assertEquals('p', $elementClone->getType());

        $this->assertEquals('wibble', $elementClone->getAttribute('class'));
        $this->assertEquals('wobble', $elementClone->getChildren()[0]->getAttribute('class'));

        $this->assertFalse($outerElement->getAttribute('class'));
        $this->assertFalse($outerElement->getChildren()[0]->getAttribute('class'));
    }

    public function testCloneElementWithTwoLevelsChild()
    {
        $outerElement = new Element('div');
        $innerElement = new Element('div');
        $innerInnerElement = new Element('div');

        $outerElement->addChild($innerElement);
        $innerElement->addChild($innerInnerElement);

        $elementClone = clone $outerElement;

        $elementClone->setAttribute('class', 'wibble');
        $elementClone->getChildren()[0]->setAttribute('class', 'wobble');
        $elementClone->getChildren()[0]->getChildren()[0]->setAttribute('class', 'foo');

        $this->assertFalse($outerElement->getAttribute('class'));
        $this->assertFalse($outerElement->getChildren()[0]->getAttribute('class'));
        $this->assertFalse($outerElement->getChildren()[0]->getChildren()[0]->getAttribute('class'));

        $this->assertEquals('wibble', $elementClone->getAttribute('class'));
        $this->assertEquals('wobble', $elementClone->getChildren()[0]->getAttribute('class'));
        $this->assertEquals('foo', $elementClone->getChildren()[0]->getChildren()[0]->getAttribute('class'));
    }

    public function testGetChildTypes()
    {
        $outer_element = new Element('div');
        $inner_element = new Element('ul');
        $inner_inner_element = new Element('li');

        $outer_element->addChild($inner_element);
        $inner_element->addChild($inner_inner_element);

        $outer_element->setAttribute('class', 'wibble');
        $inner_element->setAttribute('class', 'wobble');
        $inner_inner_element->setAttribute('class', 'foo');

        $childrenTypes = $outer_element->getChildTypes();
        $this->assertEquals('ul', $childrenTypes[0]);
        $this->assertEquals('li', $childrenTypes[1]);
    }

    public function testGetAllTypes()
    {
        $outer_element = new Element('div');
        $inner_element = new Element('ul');
        $inner_inner_element = new Element('li');

        $outer_element->addChild($inner_element);
        $inner_element->addChild($inner_inner_element);

        $outer_element->setAttribute('class', 'wibble');
        $inner_element->setAttribute('class', 'wobble');
        $inner_inner_element->setAttribute('class', 'foo');

        $types = $outer_element->getAllTypes();
        $this->assertEquals('div', $types[0]);
        $this->assertEquals('ul', $types[1]);
        $this->assertEquals('li', $types[2]);
    }

    public function testGetChildClasses()
    {
        $outer_element = new Element('div');
        $inner_element = new Element('ul');
        $inner_inner_element = new Element('li');

        $outer_element->addChild($inner_element);
        $inner_element->addChild($inner_inner_element);

        $outer_element->setAttribute('class', 'wibble');
        $inner_element->setAttribute('class', 'wobble');
        $inner_inner_element->setAttribute('class', 'foo');

        $childClasses = $outer_element->getChildClasses();
        $this->assertEquals('wobble', $childClasses[0]);
        $this->assertEquals('foo', $childClasses[1]);
    }

    public function testGetAllClasses()
    {
        $outer_element = new Element('div');
        $inner_element = new Element('ul');
        $inner_inner_element = new Element('li');

        $outer_element->addChild($inner_element);
        $inner_element->addChild($inner_inner_element);

        $outer_element->setAttribute('class', 'wibble');
        $inner_element->setAttribute('class', 'wobble');
        $inner_inner_element->setAttribute('class', 'foo');

        $classes = $outer_element->getAllClasses();
        $this->assertEquals('wibble', $classes[0]);
        $this->assertEquals('wobble', $classes[1]);
        $this->assertEquals('foo', $classes[2]);
    }

    public function testSetElementText()
    {
        $object = new Element();
        $object->setType('div');
        $object->setElementText('sometext');
        $this->assertEquals('div', $object->getType());
        $this->assertEquals('sometext', $object->getElementText());
    }

    public function testGetChildTypesOfOuterObject()
    {
        $innerObject = new Element('div');
        $outerObject = new Element($innerObject);
        $this->assertEquals(false, $outerObject->getAvailableChildTypes());
    }

    public function testEmbedObjectInElement()
    {
        $innerObject = new Element('div');
        $outerObject = new Element();
        $outerObject->setObject($innerObject);
        $this->assertEquals(false, $outerObject->getAvailableChildTypes());
        $this->assertEquals('div', $outerObject->getObject()->getType());
    }

    public function testCloneEmbeddedObjectElement()
    {
        $innerObject = new Element('div');
        $outerObject = new Element();
        $outerObject->setObject($innerObject);
        $outerObject->getObject()->setAttribute('class', 'test');

        $elementClone = clone $outerObject;
        $elementClone->getObject()->setType('p');
        $elementClone->getObject()->setAttribute('class', 'wobble');

        $this->assertEquals('div', $outerObject->getObject()->getType());
        $this->assertEquals('p', $elementClone->getObject()->getType());

        $this->assertEquals('test', $outerObject->getObject()->getAttribute('class'));
        $this->assertEquals('wobble', $elementClone->getObject()->getAttribute('class'));
    }

    public function testGetSelectorList()
    {
        $element1 = new Element();
        $element1->setType('div');

        $element2 = new Element();
        $element2->setType('div');
        $element2->setAttribute('class', 'something');

        $element3 = new Element();
        $element3->setType('div');
        $element3->setAttribute('class', 'bla');

        $element4 = new Element();
        $element4->setType('div');
        $element4->setAttribute('id', 'important');

        $element1->addChild($element2);
        $element2->addChild($element3);
        $element1->addChild($element4);

        $element1->getAllSelectors();

        $selectors = $element1->getAllSelectors();
        $this->assertEquals('div', $selectors[0]);
        $this->assertEquals('div.something', $selectors[1]);
        $this->assertEquals('div.bla', $selectors[2]);
        $this->assertEquals('div#important', $selectors[3]);
    }

    public function testSelectRandomChild()
    {
        $element1 = new Element('div');
        $element1->setAttribute('class', 'div1');

        $element2 = new Element('div');
        $element2->setAttribute('class', 'div2');

        $element3 = new Element('div');
        $element3->setAttribute('class', 'div3');

        $element4 = new Element('div');
        $element4->setAttribute('class', 'div4');

        $element5 = new Element('div');
        $element5->setAttribute('class', 'div5');

        $element1->addChild($element2);
        $element2->addChild($element3);
        $element3->addChild($element4);
        $element4->addChild($element5);

        $child = $element1->getRandomElement();

        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Element\Element', $child);
    }

    public function testRemoveChild()
    {
        $element1 = new Element('div');
        $element1->setAttribute('class', 'div1');

        $element2 = new Element('div');
        $element2->setAttribute('class', 'div2');

        $element3 = new Element('div');
        $element3->setAttribute('class', 'div3');

        $element4 = new Element('div');
        $element4->setAttribute('class', 'div4');

        $element5 = new Element('div');
        $element5->setAttribute('class', 'div5');

        $element1->addChild($element2);
        $element2->addChild($element3);
        $element3->addChild($element4);
        $element4->addChild($element5);

        $result = $element1->removeChild($element3);

        $allElements = $element1->getAllElements();

        $this->assertLessThan(5, count($allElements));
        $this->assertTrue($result);
    }

    public function testRemoveNonExistentChild()
    {
        $element1 = new Element('div');
        $element1->setAttribute('class', 'div1');

        $element2 = new Element('div');
        $element2->setAttribute('class', 'div2');

        $element3 = new Element('div');
        $element3->setAttribute('class', 'div3');

        $element4 = new Element('div');
        $element4->setAttribute('class', 'div4');

        $element5 = new Element('div');
        $element5->setAttribute('class', 'div5');

        $outsideElement = new Element('div');
        $outsideElement->setAttribute('class', 'outside');

        $element1->addChild($element2);
        $element2->addChild($element3);
        $element3->addChild($element4);
        $element4->addChild($element5);

        $result = $element1->removeChild($outsideElement);

        $allElements = $element1->getAllElements();

        $this->assertEquals(5, count($allElements));
        $this->assertFalse($result);
    }

    public function testRemoveRandomChild()
    {
        $element1 = new Element('div');
        $element1->setAttribute('class', 'div1');

        $element2 = new Element('div');
        $element2->setAttribute('class', 'div2');

        $element3 = new Element('div');
        $element3->setAttribute('class', 'div3');

        $element4 = new Element('div');
        $element4->setAttribute('class', 'div4');

        $element5 = new Element('div');
        $element5->setAttribute('class', 'div5');

        $element1->addChild($element2);
        $element2->addChild($element3);
        $element3->addChild($element4);
        $element4->addChild($element5);

        $element1->removeRandomChild();

        $allElements = $element1->getAllElements();

        $this->assertLessThan(5, count($allElements));
    }
}
