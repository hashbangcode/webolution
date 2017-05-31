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
     * NumberIndividual constructor.
     *
     * @param $number
     */
    public function __construct($number)
    {
        $this->object = new Number($number);
    }

    /**
     * @return \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual
     */
    public static function generateRandomNumber()
    {
        $number = mt_rand(1, 10);
        return new NumberIndividual($number);
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
        return $this->getObject()->getNumber();
    }

    /**
     * {@inheritdoc}
     */
    public function render($renderType = 'cli')
    {
        switch ($renderType) {
            case 'html':
                $output = $this->object->render() . ' ';
                break;
            case 'cli':
            default:
                $output = $this->object->render() . ' ';
        }
        return $output;
    }
}
