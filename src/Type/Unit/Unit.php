<?php

namespace Hashbangcode\Webolution\Type\Unit;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\Type\Unit\Exception\InvalidUnitException;
use Hashbangcode\Webolution\Type\Unit\Exception\InvalidNumberException;

/**
 * Class Number.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class Unit implements TypeInterface
{
    /**
     * The number.
     *
     * @var int
     */
    protected $number;

    /**
     * The unit of the number.
     *
     * @var string
     */
    protected $unit;

    /**
     * Get the unit.
     *
     * @return string
     *   The unit.
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set the unit.
     *
     * @param string $unit
     *   The unit.
     *
     * @throws InvalidUnitException
     */
    public function setUnit($unit)
    {
        if ($unit != 'em' && $unit != 'px' && $unit != '%' && $unit != 'auto') {
            throw new InvalidUnitException($unit . ' is not a valid unit.');
        }

        $this->unit = $unit;
    }

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
     * @throws InvalidNumberException
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
     * @param string $unit
     *   The unit.
     *
     * @throws InvalidNumberException
     * @throws InvalidUnitException
     */
    public function __construct($number, $unit)
    {
        $this->setNumber($number);
        $this->setUnit($unit);
    }

    /**
     * Generate a Unit object with some random properties.
     *
     * @return Unit
     *   A new unit object with random properties.
     *
     * @throws InvalidNumberException
     * @throws InvalidUnitException
     */
    public static function generateRandomUnit()
    {
        $number = mt_rand(1, 500);
        $units = ['px', 'em', '%', 'auto'];
        $unit = $units[array_rand($units)];
        return new Unit($number, $unit);
    }

    /**
     * Add an amount to the number.
     *
     * @param int $x
     *   The number.
     *
     * @return Unit
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
     * @param int $x
     *   The number.
     *
     * @return Unit
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
