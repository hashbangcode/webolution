<?php

namespace Hashbangcode\Webolution\Type\Number;

use Hashbangcode\Webolution\Individual;

/**
 * Class NumberIndividual
 * @package Hashbangcode\Webolution\Individual
 */
class NumberIndividual extends Individual
{
    /**
     * Generate a NumberIndividual from a Number object.
     *
     * @param int $number
     *   The number.
     * @return NumberIndividual
     *   The new NumberIndividual object.
     *
     * @throws \Hashbangcode\Webolution\Type\Number\Exception\InvalidNumberException
     */
    public static function generateFromNumber($number)
    {
        return new self(new Number($number));
    }

    /**
     * Generate a random NumberIndividual containing a new Number object.
     *
     * @return NumberIndividual
     *   A new NumberIndividual object.
     *
     * @throws \Hashbangcode\Webolution\Type\Number\Exception\InvalidNumberException
     */
    public static function generateRandomNumber()
    {
        return new self(new Number(mt_rand(1, 10)));
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
