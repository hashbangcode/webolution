<?php

namespace Hashbangcode\Wevolution\Test\Type\Element;

use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Test class for Color
 */
class ElementTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateObject()
    {
        $object = new Element();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Element', $object);
    }

    public function testCreateEmptyDivElement()
    {
        $object = new Element();
        $object->setType('div');
        $this->assertEquals('div', $object->getType('div'));
        $this->assertEquals('<div></div>', $object->render());
    }

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

    public function testCreateDivElementWithAttribute()
    {
        $object = new Element();
        $object->setType('div');
        $object->setAttributes(array('id' => 'test'));
        $this->assertEquals('div', $object->getType('div'));
        $this->assertEquals('<div id="test"></div>', $object->render());
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

    public function testCreateSinglyNestedDivElement()
    {
        $outer_element = new Element();
        $outer_element->setType('div');

        $inner_element = new Element();
        $inner_element->setType('div');

        $outer_element->addChild($inner_element);

        $this->assertEquals('div', $outer_element->getType('div'));
        $this->assertEquals('div', $inner_element->getType('div'));
        $this->assertEquals('<div><div></div></div>', $outer_element->render());
    }

    public function testAddInvalidChild()
    {
        $outer_element = new Element();
        $outer_element->setType('ol');

        $inner_element = new Element();
        $inner_element->setType('div');

        $message = 'Cant add child of type "div" to "ol"';
        $this->setExpectedException('Hashbangcode\Wevolution\Type\Element\Exception\InvalidChildTypeException', $message);
        $outer_element->addChild($inner_element);
    }

    public function testCreateDoublyNestedDivElement()
    {
        $outer_element = new Element();
        $outer_element->setType('div');

        $inner_element = new Element();
        $inner_element->setType('div');

        $inner_inner_element = new Element();
        $inner_inner_element->setType('div');

        $inner_element->addChild($inner_inner_element);

        $outer_element->addChild($inner_element);

        $this->assertEquals('div', $outer_element->getType('div'));
        $this->assertEquals('div', $inner_element->getType('div'));
        $this->assertEquals('div', $inner_inner_element->getType('div'));
        $this->assertEquals('<div><div><div></div></div></div>', $outer_element->render());
    }

    public function testCreateSinglyNestedDivElementWithMultipleChildren()
    {
        $outer_element = new Element();
        $outer_element->setType('div');

        $inner_element1 = new Element();
        $inner_element1->setType('div');

        $outer_element->addChild($inner_element1);

        $inner_element2 = new Element();
        $inner_element2->setType('div');

        $outer_element->addChild($inner_element2);

        $this->assertEquals('div', $outer_element->getType('div'));
        $this->assertEquals('div', $inner_element1->getType('div'));
        $this->assertEquals('div', $inner_element2->getType('div'));
        $this->assertEquals('<div><div></div><div></div></div>', $outer_element->render());
    }

    public function testSetIncorrectAttributes()
    {
        $element = new Element();
        $element->setType('p');
        $this->setExpectedException('Hashbangcode\Wevolution\Type\Element\Exception\InvalidAttributesException');
        $element->setAttributes(2);
    }

    public function testSetChildElement()
    {
        $element = new Element('ul');
        $child_types = $element->getAvailableChildTypes($element->getType());
        $this->assertEquals('li', $child_types[0]);
    }

    /**
     * @dataProvider elementChildTypes
     */
    public function testGetAvailableChildTypes($type, $childTypes)
    {
        $element = new Element($type);
        $returnedChildTypes = $element->getAvailableChildTypes($element->getType());

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
           ['type' => 'p', 'childTypes' => ['ul', 'ol', 'div', 'p', 'h1', 'h2']],
        ];
    }

    public function testCloneElement()
    {
        $element = new Element();
        $element->setType('div');

        $element_clone = clone $element;

        $element_clone->setAttribute('class', 'wibble');

        $this->assertEquals('<div></div>', $element->render());
        $this->assertEquals('<div class="wibble"></div>', $element_clone->render());
    }

    public function testCloneElementWithChild()
    {
        $outer_element = new Element();
        $outer_element->setType('div');

        $inner_element = new Element();
        $inner_element->setType('div');

        $outer_element->addChild($inner_element);

        $element_clone = clone $outer_element;

        $element_clone->setAttribute('class', 'wibble');

        $element_clone->getChildren()[0]->setAttribute('class', 'wobble');

        $this->assertEquals('<div><div></div></div>', $outer_element->render());
        $this->assertEquals('<div class="wibble"><div class="wobble"></div></div>', $element_clone->render());
    }

    public function testCloneElementWithTwoLevelsChild()
    {
        $outer_element = new Element('div');
        $inner_element = new Element('div');
        $inner_inner_element = new Element('div');

        $outer_element->addChild($inner_element);
        $inner_element->addChild($inner_inner_element);

        $element_clone = clone $outer_element;

        $element_clone->setAttribute('class', 'wibble');
        $element_clone->getChildren()[0]->setAttribute('class', 'wobble');
        $element_clone->getChildren()[0]->getChildren()[0]->setAttribute('class', 'foo');

        $expected = '<div><div><div></div></div></div>';
        $this->assertEquals($expected, $outer_element->render());
        $expected = '<div class="wibble"><div class="wobble"><div class="foo"></div></div></div>';
        $this->assertEquals($expected, $element_clone->render());
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
        $this->assertEquals('div', $object->getType('div'));
        $this->assertEquals('<div>sometext</div>', $object->render());
        $this->assertEquals('sometext', $object->getElementText());
    }

    public function testRenderInnerObject()
    {
        $innerObject = new Element('div');
        $outerObject = new Element($innerObject);
        $this->assertEquals('<div></div>', $outerObject->render());
    }

    public function testRenderInnerObjectAfterSettingType()
    {
        $innerObject = new Element('div');
        $outerObject = new Element($innerObject);
        $outerObject->setType('p');
        $this->assertEquals('<div></div>', $outerObject->render());
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
        $this->assertEquals('<div></div>', $outerObject->render());
    }

    public function testCloneEmbeddedObjectElement()
    {
        $innerObject = new Element('div');
        $outerObject = new Element();
        $outerObject->setObject($innerObject);

        $element_clone = clone $outerObject;

        $outerObject->getObject()->setAttribute('class', 'test');

        $element_clone->getObject()->setAttribute('class', 'wobble');

        $this->assertEquals('<div class="test"></div>', $outerObject->render());
        $this->assertEquals('<div class="wobble"></div>', $element_clone->render());
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

        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Element', $child);
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
