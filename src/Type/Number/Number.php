<?php

namespace Hashbangcode\Webolution\Type\Number;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\Type\Number\Exception\InvalidNumberException;

/**
 * Class Number.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class Number implements TypeInterface
{
    /**
     * @var int The number.
     */
    protected $number;

    /**
     * Get the number.
     *
     * @return mixed
     *   The number.
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the number.
     *
     * @param int $number
     *   The number.
     *
     * @throws Exception\InvalidNumberException
     */
    public function setNumber($number)
    {
        if (!is_int($number)) {
            throw new InvalidNumberException($number . ' is not a number.');
        }

        $this->number = $number;
    }

    /**
     * Number constructor.
     *
     * @param int $number
     *   The number.
     *
     * @throws InvalidNumberException
     */
    public function __construct($number)
    {
        $this->setNumber($number);
    }

    /**
     * Add an amount to the number.
     *
     * @param $x integer
     *   The number.
     *
     * @return $this
     *   The current object.
     *
     * @throws InvalidNumberException
     */
    public function add($x)
    {
        $this->setNumber($this->getNumber() + $x);
        return $this;
    }

    /**
     * Subtract an amount from the number.
     *
     * @param $x integer
     *   The number.
     *
     * @return $this
     *   The current object.
     *
     * @throws InvalidNumberException
     */
    public function subtract($x)
    {
        $this->setNumber($this->getNumber() - $x);
        return $this;
    }
}
