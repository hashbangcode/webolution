<?php

namespace Hashbangcode\Wevolution\Type\Page;

use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Type\TypeInterface;

/**
 * Class Page.
 *
 * @package Hashbangcode\Wevolution\Type\Page
 */
class Page implements TypeInterface
{
    /**
     * The page styles.
     *
     * @var array
     */
    protected $styles = [];

    /**
     * The root Element object.
     *
     * @var Element
     */
    protected $body;

    /**
     * Get styles.
     *
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Set the style array.
     *
     * @param array $styles
     *   Set the styles array.
     */
    public function setStyles(array $styles)
    {
        foreach ($styles as $style) {
            if (!isset($this->styles[$style->getSelector()])) {
                $this->styles[$style->getSelector()] = $style;
            }
        }
    }

    /**
     * Get a style.
     *
     * @param string $selector
     *   The selector.
     *
     * @return bool|mixed
     *   The style object, or false if not present.
     */
    public function getStyle($selector)
    {
        if (!isset($this->styles[$selector])) {
            return false;
        }
        return $this->styles[$selector];
    }

    /**
     * Set a single style to the list of styles the page has.
     *
     * @param Style $style
     *   The Style object to add.
     */
    public function setStyle(Style $style)
    {
        $this->styles[$style->getSelector()] = $style;
    }

    /**
     * Get the body Element Object.
     *
     * @return Element
     *   The Element.
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the Element object.
     *
     * @param Element $body
     *   The Element object.
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get all the classes from the body Element.
     *
     * @return array
     *   The array of classes from the body.
     */
    public function getBodyClasses()
    {
        return $this->getBody()->getAllClasses();
    }

    /**
     * Get all of the element types from the body element.
     *
     * @return mixed
     *   The array of element types.
     */
    public function getBodyElementTypes()
    {
        return $this->getBody()->getAllTypes();
    }

    /**
     * Get the available selectors for the body element.
     *
     * @return array
     *   The list of selectors.
     */
    public function getSeletors()
    {
        return $this->getBody()->getAllSelectors();
    }

    /**
     * Generate the styles for the page based on the element selectors.
     */
    public function generateStylesFromBody()
    {
        $selectors = $this->getSeletors();
        $styles = [];
        foreach ($selectors as $selector) {
            $styles[$selector] = new Style($selector);
        }
        $this->setStyles($styles);
    }

    /**
     * Purge any styles that do not have corresponding elements.
     */
    public function purgeStylesWithoutElements()
    {
        $selectors = $this->getSeletors();
        $styles = $this->getStyles();
        foreach ($styles as $key => $style) {
            if (!in_array($key, $selectors)) {
                unset($styles[$key]);
            }
        }
        $this->styles = $styles;
    }

    /**
     * Implements __clone().
     */
    public function __clone()
    {
        // Clone the styles array.
        foreach ($this->styles as $key => $style) {
            $this->styles[$key] = clone $style;
        }

        // Clone the body, this will clone all child elements.
        $this->body = clone $this->body;
    }
}
