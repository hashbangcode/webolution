<?php

namespace Hashbangcode\Webolution\Type\Text;

use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class Text
 * @package Hashbangcode\Webolution\Type\Text
 */
class Text implements TypeInterface
{
    /**
     * The text.
     *
     * @var string
     */
    protected $text = '';

    /**
     * Get the text.

     * @return string
     *  The text.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the text.
     *
     * @param string $text
     *   The text to set.
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Text constructor.
     *
     * @param string $text
     *   The text to add.
     */
    public function __construct($text)
    {
        $this->setText($text);
    }
}
