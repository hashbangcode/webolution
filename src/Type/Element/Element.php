<?php

namespace Hashbangcode\Webolution\Type\Element;

use Hashbangcode\Webolution\Type\Element\Exception\InvalidChildTypeException;
use Hashbangcode\Webolution\Generators\RandomText;
use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class Element.
 *
 * @package Hashbangcode\Webolution\Type\Element
 */
class Element implements TypeInterface
{

    use RandomText;

    /**
     * @var bool|string The type of element.
     */
    protected $type;

    /**
     * @var array An associative array of attributes.
     */
    protected $attributes = null;

    /**
     * @var array The children of this element.
     */
    protected $children = [];

    /**
     * @var string The text node of this element.
     */
    protected $elementText = '';

    /**
     * @var bool|object An optional object that can be used in place of an element.
     */
    protected $object = false;

    /**
     * Get the object.
     *
     * @return bool|object
     *   The object.
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set the object.
     *
     * @param object $object
     */
    public function setObject($object)
    {
        if (is_object($object)) {
            $this->type = false;
            $this->object = $object;
        }
    }

    /**
     * Element constructor.
     *
     * @param string|object $arg
     *   The element type or an Element object.
     */
    public function __construct($arg = 'div')
    {
        if (is_object($arg)) {
            // This is an object so we store it differently.
            $this->type = false;
            $this->object = $arg;
        } else {
            // This is a string so we create a normal Element object.
            $this->type = $arg;

            if (in_array($arg, $this->getTextTypes())) {
                // @todo some text elements should create more text than other text elements.
                // for example, a h1 tag would contain 10-20 characters
                // a p tag would contain a lot more text.
                $this->elementText = $this->generateRandomText(15);
            }
        }
    }

    /**
     * Get the types of element that should have text values within then.
     *
     * @return array
     *   The list of text elements.
     */
    public function getTextTypes()
    {
        return [
            'p',
            'li',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'strong',
            'em',
        ];
    }

    /**
     * Get the attributes for the Element. For example, setting the key to "class" and the value to "test" will
     * translate into 'class="test"' when rendered.
     *
     * @param string $key
     *   The key of the attribute.
     * @param string $value
     *   The value of the attribute.
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get the type of element.
     *
     * @return mixed
     *   The element type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of Element.
     *
     * @param mixed $type
     *   The type of element to set.
     */
    public function setType($type)
    {
        if ($this->type !== false) {
            // Ensure that all element types are lower case.
            $this->type = strtolower($type);
        }
    }

    /**
     * Get the attributes of an Element.
     *
     * @return array|null
     *   All of the attributes for the Element, or null if none are set.
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get a specific attribute of an Element.
     *
     * @param string $type
     *   The type of attribute to set.
     *
     * @return mixed
     *   The value of the attribute, or false if that attribute isn't set.
     */
    public function getAttribute($type)
    {
        if (isset($this->attributes[$type])) {
            return $this->attributes[$type];
        }

        return false;
    }

    /**
     * Set the attributes of an Element.
     *
     * @param array $attributes
     *   The attributes as a key/value array.
     *
     * @throws Exception\InvalidAttributesException
     */
    public function setAttributes($attributes)
    {
        if (!is_array($attributes)) {
            throw new Exception\InvalidAttributesException('Array of attributes required.');
        }

        $this->attributes = $attributes;
    }

    /**
     * Get the children of this Element.
     *
     * @return array
     *   The Element children.
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get the Element text.
     *
     * @return string
     *   The Element text.
     */
    public function getElementText()
    {
        return $this->elementText;
    }

    /**
     * Set the text of the Element.
     *
     * @param string $elementText
     *   The text to set.
     */
    public function setElementText($elementText)
    {
        $this->elementText = $elementText;
    }

    /**
     * Add a child to the Element.
     *
     * @param Element $element
     *   The Element to add as a child.
     *
     * @throws Exception\InvalidChildTypeException
     */
    public function addChild(Element $element)
    {
        if (is_array($this->getAvailableChildTypes()) && !in_array($element->getType(), $this->getAvailableChildTypes())) {
            // Invalid child Element.
            $message = 'Cant add child of type "' . $element->getType() . '" to "' . $this->getType() . '".';
            throw new Exception\InvalidChildTypeException($message);
        }

        $this->children[] = $element;
    }

    /**
     * Get the child type appropriate for the current element.
     *
     * This method is intended to stop (for example) li elements being children of
     * div elements and allows a more symantically correct page to be generated.
     *
     * @return array|bool
     *   The child types that can be used. False if no type is set.
     */
    public function getAvailableChildTypes()
    {
        if ($this->type === false) {
            return false;
        }

        switch ($this->type) {
            case 'html':
                return [
                    'body'
                ];
            case 'head':
                return [
                    'style'
                ];
            case 'ul':
            case 'ol':
                return [
                    'li'
                ];
            default:
                return [
                    'ul',
                    'ol',
                    'div',
                    'p',
                    'h1',
                    'h2',
                    'h3',
                    'h4',
                    'h5',
                    'strong',
                    'em',
                ];
        }
    }

    /**
     * Implements __clone().
     */
    public function __clone()
    {
        if (is_object($this->object)) {
            $this->object = clone $this->object;
        }

        // Clone the children of this object.
        foreach ($this->children as $key => $child) {
            // When cloning a child all children will also be cloned.
            $this->children[$key] = clone $child;
        }
    }

    /**
     * Get all types contained within the object structure.
     *
     * @return array
     *   The types.
     */
    public function getAllTypes()
    {
        $types = $this->getChildTypes();
        $types = array_merge([$this->getType()], $types);
        return $types;
    }

    /**
     * Get the available child types for the Element.
     *
     * @return array
     *   The child types.
     */
    public function getChildTypes()
    {
        $types = [];

        foreach ($this->getChildren() as $child) {
            $types[] = $child->getType();
            if (count($child->getChildren()) > 0) {
                $children = $child->getChildTypes();
                $types = array_merge($types, $children);
            }
        }

        return $types;
    }

    /**
     * Get all classes.
     *
     * @return array
     *   The list of classes.
     */
    public function getAllClasses()
    {
        $classes = $this->getChildClasses();
        $classes = array_merge([$this->getAttribute('class')], $classes);
        $classes = array_filter($classes);
        return $classes;
    }

    /**
     * Get all of the child types of the element.
     *
     * @return array
     *   The list of child types.
     */
    public function getChildClasses()
    {
        $types = [];

        foreach ($this->getChildren() as $child) {
            $class = $child->getAttribute('class');
            if ($class !== false) {
                $types[] = $class;
            }
            if (count($child->getChildren()) > 0) {
                $children = $child->getChildClasses();
                $types = array_merge($types, $children);
            }
        }

        return $types;
    }

    /**
     * Get a list of all selectors in the element and child elements.
     *
     * @return array
     *   The list of selectors.
     */
    public function getAllSelectors()
    {
        $selectors = $this->getChildSelectors();
        $selectors = array_merge([$this->extractSelector()], $selectors);
        return $selectors;
    }

    /**
     * Get all child selectors.
     *
     * @return array
     *   The child selectors.
     */
    public function getChildSelectors()
    {
        $list = [];

        foreach ($this->getChildren() as $child) {
            $list[] = $child->extractSelector();
            if (count($child->getChildren()) > 0) {
                $children = $child->getChildSelectors();
                $list = array_merge($list, $children);
            }
        }

        return $list;
    }

    /**
     * Extract a selected from an element.
     *
     * @return mixed|string
     *  The selector for the element.
     */
    public function extractSelector()
    {
        $selector = $this->getType();
        if ($this->getAttribute('id') !== false) {
            $selector .= '#' . $this->getAttribute('id');
        } elseif ($this->getAttribute('class') !== false) {
            $selector .= '.' . $this->getAttribute('class');
        }
        return $selector;
    }

    /**
     * Get all elements (including the current object.
     *
     * @return array
     *   All of the elements.
     */
    public function getAllElements()
    {
        $elements = $this->getAllChildElements();
        $elements[] = $this;
        return $elements;
    }

    /**
     * Get all of the child elements.
     *
     * @return array
     *   A list of child elements.
     */
    public function getAllChildElements()
    {
        $list = [];

        foreach ($this->getChildren() as $child) {
            $list[] = $child;
            if (count($child->getChildren()) > 0) {
                $children = $child->getAllChildElements();
                $list = array_merge($list, $children);
            }
        }

        return $list;
    }

    /**
     * Get a random element from this object.
     *
     * @return mixed
     *   A random element.
     */
    public function getRandomElement()
    {
        $elements = $this->getAllElements();
        return $elements[array_rand($elements)];
    }

    /**
     * Remove a random child element.
     */
    public function removeRandomChild()
    {
        $allChildren = $this->getAllChildElements();
        if (count($allChildren) > 0) {
            // We have children, so remove one of them.
            $randomChild = $allChildren[array_rand($allChildren)];
            $this->removeChild($randomChild);
        }
    }

    /**
     * Given an Element object, remove it from the children of the current object.
     *
     * @param Element $removeChild
     *   The element to remove.
     * @return bool
     *   True if element was removed.
     */
    public function removeChild($removeChild)
    {
        foreach ($this->getChildren() as $key => $child) {
            // Loop through the children of this element and remove a child if it matches.
            if ($child === $removeChild) {
                unset($this->children[$key]);
                return true;
            }

            if (count($child->getChildren()) > 0) {
                // This element has children so go into those children in an attempt to find the correct element.
                return $child->removeChild($removeChild);
            }
        }
        // No child was removed, so return false.
        return false;
    }
}
