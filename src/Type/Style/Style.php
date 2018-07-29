<?php

namespace Hashbangcode\Webolution\Type\Style;

use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class Style. This class represents the css style object.
 *
 * @package Hashbangcode\Webolution\Type\Style
 */
class Style implements TypeInterface
{
    /**
     * The style selector.
     *
     * @var null|string
     */
    protected $selector = '';

    /**
     * @var array
     *   The style attributes.
     */
    protected $attributes = [];

    /**
     * Style constructor.
     *
     * @param string|null $selector
     *   The selector.
     * @param array|null $attributes
     *   A list of attributes to set with the selector.
     */
    public function __construct($selector = null, $attributes = null)
    {
        if (!is_null($selector)) {
            $this->selector = $selector;
        }

        if (!is_null($attributes) && is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    /**
     * Get a single attribute value.
     *
     * @param string $name
     *   Attribute name.
     *
     * @return bool|mixed
     *   Attribute value, or false if the attribute is not present.
     */
    public function getAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return false;
    }

    /**
     * Get the selector.
     *
     * @return null|string
     *   Get the selector.
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Set the selector.
     *
     * @param null|string $selector
     *   Get the selector.
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;
    }

    /**
     * Get all attributes.
     *
     * @return array
     *   A list of attributes to replace the current attributes list.
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set all attributes.
     *
     * @param array $attributes
     *   Array of attibutes, as a key value set.
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Called when the object is cloned.
     */
    public function __clone()
    {
        // If any of the attributes are objects then ensure they are cloned.
        foreach ($this->getAttributes() as $key => $attribute) {
            if (is_object($attribute)) {
                $this->setAttribute($key, clone $attribute);
            }
        }
    }

    /**
     * Set an attrobite.
     *
     * @param string $name
     *   Name of the attribute.
     * @param string $value
     *   Value to set the attribute to.
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
