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
            $this->styles[$style->getSelector()] = $style;
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
     * Render the page.
     *
     * @return string
     *   The rendered page.
     */
    public function render()
    {
        // Set up output variables.
        $style = '';
        $body = '';

        // Render the styles.
        if (count($this->getStyles()) > 0) {
            foreach ($this->getStyles() as $styleObject) {
                if ($styleObject instanceof Style) {
                    $style .= $styleObject->render();
                }
            }
            // Wrap the style in tags.
            $style = '    <style>' . $style . '</style>' . PHP_EOL;
        }

        // Render the body.
        if ($this->getBody() instanceof Element) {
            $body .= $this->getBody()->render() . PHP_EOL;
        }

        // Put the pieces together.
        ob_start();
        include 'template.php';
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}
