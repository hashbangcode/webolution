<?php

namespace Hashbangcode\Wevolution\Type\Page;

use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Type\TypeInterface;

/**
 * Class Page
 * @package Hashbangcode\Wevolution\Type\Page
 */
class Page implements TypeInterface
{
    /**
     * @var Style
     *   The Style object.
     */
    protected $style;

    /**
     * @var Element
     *   The root Element object.
     */
    protected $body;

    /**
     * @return Style
     *   The Style object.
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set the Style object.
     *
     * @param Style $style
     *   Set the Style object.
     */
    public function setStyle($style)
    {
        $this->style = $style;
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
     * Render the page.
     *
     * @return string
     *   The rendered page.
     */
    public function render()
    {
        $style = '';

        if ($this->getStyle() instanceof Style) {
            $style = PHP_EOL . '<style>' . $this->getStyle()->render() . '</style>';
        }

        $body = '';

        if ($this->getBody() instanceof Element) {
            $body = PHP_EOL . $this->getBody()->render();
        }

        return '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>' . $style . '
    </head>
    <body>' . $body . '
    </body>
</html>';
    }
}