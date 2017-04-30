<?php

namespace Hashbangcode\Wevolution\Type\Text;

use Hashbangcode\Wevolution\Type\TypeInterface;

/**
 * Class Text
 * @package Hashbangcode\Wevolution\Type\Text
 */
class Text implements TypeInterface
{
    protected $text;

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Text constructor.
     * @param $text
     */
    public function __construct($text)
    {
        $this->setText($text);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return $this->getText();
    }
}