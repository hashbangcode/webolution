<?php

namespace Hashbangcode\Wevolution\Type\Style;

class Style
{

    /**
     * The style selector.
     *
     * @var null|string
     */
    protected $selector = '';

    /**
     * Get the selector.
     *
     * @return null|string
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Get the selector.
     *
     * @param null|string $selector
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;
    }

    /**
     * The style attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Style constructor.
     *
     * @param null $selector
     * @param null $attributes
     */
    public function __construct($selector = NULL, $attributes = NULL)
    {
        if (!is_null($selector)) {
            $this->selector = $selector;
        }

        if (!is_null($attributes) && is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    /**
     * Get all attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set all attributes.
     *
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Set an attrobite.
     *
     * @param $name The name of the attribute.
     * @param $value The value to set the attribute to.
     */
    public function setAttrbute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Get a single attribute value.
     *
     * @param $name The attribute name.
     *
     * @return bool|mixed The attribute value, or false if the attribute is not present.
     */
    public function getAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return false;
    }

    /**
     * Render the style.
     */
    public function render()
    {
        $output = '';

        $output .= $this->getSelector() . '{';

        foreach ($this->getAttributes() as $attribute => $value) {
            // Render the style.
            if (is_object($value)) {
                $output .= $attribute . ':' . $value->render('css') . ';';
            } else {
                $output .= $attribute . ':' . $value . ';';
            }
        }

        $output .= '}';

        return $output;
    }

    /**
     *
     */
    public function __clone()
    {
        foreach ($this->getAttributes() as $key => $attribute) {
            if (is_object($attribute)) {
                $this->setAttrbute($key, clone $attribute);
            }
        }
    }
}