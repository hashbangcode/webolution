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

            $number = $this->getObject()->getNumber();

            switch ($operators[array_rand($operators)]) {
                case 'subtract':
                    $value = $number - $mutationAmount;
                    break;
                case 'add':
                default:
                    $value = $number + $mutationAmount;
                    break;
            }

            $this->getObject()->setNumber($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness()
    {
        return $this->getObject()->getNumber();
    }

    /**
     * @param $renderType
     * @return mixed
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
