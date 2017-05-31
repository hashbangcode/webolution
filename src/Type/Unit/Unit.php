<?php

namespace Hashbangcode\Wevolution\Type\Unit;

use Hashbangcode\Wevolution\Type\TypeInterface;
use Hashbangcode\Wevolution\Type\Unit\Exception\InvalidUnitException;
use Hashbangcode\Wevolution\Type\Unit\Exception\InvalidNumberException;

/**
 * Class Number.
 *
 * @package Hashbangcode\Wevolution\Type\Number
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
     */
    public function __construct($number, $unit)
    {
        $this->setNumber($number);
        $this->setUnit($unit);
    }

    /**
     * Add an amount to the number.
     *
     * @param $x integer
     *   The number.
     *
     * @return Unit
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
     * @return Unit
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
        if ($this->getUnit() == 'auto') {
            // If the unit is 'auto' then return just that.
            return 'auto';
        }

        // Return the combination of number and unit.
        return $this->getNumber() . '' . $this->getUnit();
    }
}
