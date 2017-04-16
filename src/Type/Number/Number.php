<?php

namespace Hashbangcode\Wevolution\Type\Number;

/**
 * Class Number.
 *
 * @package Hashbangcode\Wevolution\Type\Number
 */
class Number
{
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
     * @param integer $number
     *   The number.
     *
     * @throws Exception\InvalidNumberException
     */
    public function setNumber($number)
    {
        if (!is_int($number)) {
            throw new Exception\InvalidNumberException($number . ' is not a number.');
        } else {
            $this->number = $number;
        }
    }

    /**
     * Number constructor.
     *
     * @param integer $number
     *   The number.
     */
    public function __construct($number)
    {
        $this->setNumber($number);
    }

    /**
     * Helper function that adds two numbers.
     *
     * @param $x integer The first number.
     * @param $y integer The second number.
     * @return integer The result of adding the numbers.
     */
    protected function add($x, $y)
    {
        return $x + $y;
    }

    /**
     * Helper function that subtracts two numbers.
     *
     * @param $x integer The first number.
     * @param $y integer The second number.
     * @return integer The result of subtracting the numbers.
     */
    protected function subtract($x, $y)
    {
        return $x - $y;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return $this->getNumber();
    }
}