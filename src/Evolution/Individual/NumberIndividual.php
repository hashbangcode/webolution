<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Number\Number;

/**
 * Class NumberIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class NumberIndividual extends Individual
{
    /**
     * Generate a NumberIndividual from a Number object.
     *
     * @param int $number
     *   The number
     *
     * @return NumberIndividual
     */
    public static function generateFromNumber($number)
    {
        // Create the ColorIndividual and assign the passed Color object to it.
        $numberObject = new Number($number);
        return new self($numberObject);
    }

    /**
     * @return NumberIndividual
     */
    public static function generateRandomNumber()
    {
        $number = mt_rand(1, 10);
        $numberObject = new Number($number);
        return new self($numberObject);
    }

    /**
     * {@inheritdoc}
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $random = mt_rand(0, 100);

        if ($random > $mutationFactor) {
            $operators = array('add', 'subtract');

            switch ($operators[array_rand($operators)]) {
                case 'subtract':
                    $this->mutateNumberSubtract($mutationAmount);
                    break;
                case 'add':
                default:
                    $this->mutateNumberAdd($mutationAmount);
                    break;
            }
        }
    }

    /**
     * Add an amount to the number.
     *
     * @param int|float $mutationAmount
     *   The amount to add.
     */
    public function mutateNumberAdd($mutationAmount)
    {
        $this->getObject()->add($mutationAmount);
    }

    /**
     * Subtract an amount from the number.
     *
     * @param int|float $mutationAmount
     *   The amount to subtract.
     */
    public function mutateNumberSubtract($mutationAmount)
    {
        $this->getObject()->subtract($mutationAmount);
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        // The fitness of a NumberIndividual is literally the value of the number.
        return $this->getObject()->getNumber();
    }
}
