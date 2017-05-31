<?php

namespace Hashbangcode\Wevolution\Type\Number;

use Hashbangcode\Wevolution\Type\TypeInterface;
use Hashbangcode\Wevolution\Type\Number\Exception\InvalidNumberException;

/**
 * Class Number.
 *
 * @package Hashbangcode\Wevolution\Type\Number
 */
class Number implements TypeInterface
{
    /**
     * The number.
     *
     * @var int
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
     * @return Number
     *   The current object.
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
     * @return Number
     *   The current object.
     */
    public function subtract($x)
    {
        $this->setNumber($this->getNumber() - $x);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getNumber();
    }
}
