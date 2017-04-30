<?php

namespace Hashbangcode\Wevolution\Type\Element;

use Hashbangcode\Wevolution\Type\Element\Exception\InvalidChildTypeException;
use Hashbangcode\Wevolution\Utilities\TextUtilities;
use Hashbangcode\Wevolution\Type\TypeInterface;

class Element implements TypeInterface
{

    use TextUtilities;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $children = array();

    /**
     * @var string
     */
    protected $elementText = '';

    /**
     * An object.
     *
     * @var bool|object
     */
    protected $object = false;

    /**
     * @return bool|object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param bool|object $object
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
     * @param string $type
     *   The element type.
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
                $this->elementText = $this->generateRandomText(10);
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
        return array('p', 'li', 'h1', 'h2', 'h3', 'h4', 'h5');
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
     * Render the element.
     *
     * @return string
     *   The rendered element.
     */
    public function render()
    {
        if ($this->getType() === false && is_object($this->getObject())) {
            return $this->getObject()->render();
        }

        $output = '';

        $output .= '<' . $this->getType();

        if ($this->getAttributes() > 0) {
            $attributes = array();
            foreach ($this->getAttributes() as $attribute => $value) {
                $attributes[] = $attribute . '="' . $value . '"';
            }
            $output .= ' ' . implode(' ', $attributes);
        }

        $output .= '>';

        if (count($this->getChildren()) > 0) {
            foreach ($this->getChildren() as $index => $child) {
                $output .= $child->render();
            }
        }

        $output .= $this->getElementText();

        $output .= '</' . $this->getType() . '>';
        return $output;
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
        if (!in_array($element->getType(), $this->getAvailableChildTypes())) {
            // Invalid child Element.
            $message = 'Cant add child of type ' . $element->getType() . ' to ' . $this->getType();
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
     * @return array
     *   The child types that can be used.
     */
    public function getAvailableChildTypes()
    {
        if ($this->type === false) {
            return false;
        }

        switch ($this->type) {
            case 'html':
                return array('body');
            case 'ul':
            case 'ol':
                return array('li');
            default:
                return array('ul', 'ol', 'div', 'p', 'h1', 'h2');
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
            if (count($child->getChildren() > 0)) {
                $children = $child->getChildTypes();
                $types = array_merge($types, $children);
            }
        }

        return $types;
    }

    public function getChildClasses()
    {
        $types = [];

        foreach ($this->getChildren() as $child) {
            $class = $child->getAttribute('class');
            if ($class !== false) {
                $types[] = $class;
            }
            if (count($child->getChildren() > 0)) {
                $children = $child->getChildClasses();
                $types = array_merge($types, $children);
            }
        }

        return $types;
    }
}