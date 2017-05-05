<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

/**
 * Class Individual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
abstract class Individual implements IndividualInterface
{

    /**
     * The type object.
     * @var object
     */
    protected $object;

    /**
     * Individual constructor.
     *
     * @param int $mutationFactor
     *   The mutation factor.
     * @param int $mutationAmount
     *   The mutation amount.
     */
    public function __construct($mutationFactor = 0, $mutationAmount = 0)
    {
        $this->mutationFactor = $mutationFactor;
        $this->mutationAmount = $mutationAmount;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getFitness();

    /**
     * {@inheritdoc}
     */
    abstract public function render($renderType);

    /**
     * {@inheritdoc}
     */
    abstract public function mutate($mutationFactor = 0, $mutationAmount = 1);

    /**
     * Magic method when the object is being cloned.
     */
    public function __clone()
    {
        $object = $this->getObject();
        $this->object = clone $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getObject()
    {
        return $this->object;
    }
}