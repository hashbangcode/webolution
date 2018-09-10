<?php

namespace Hashbangcode\Webolution\Evolution\Individual;

use Hashbangcode\Webolution\Type\TypeInterface;
use phpDocumentor\Parser\Exception;

/**
 * Class Individual.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual
 */
abstract class Individual implements IndividualInterface
{
    /**
     * @var object The type object.
     */
    protected $object;

    /**
     * {@inheritdoc}
     */
    abstract public function getFitness($type = '');

    /**
     * {@inheritdoc}
     */
    abstract public function mutate($mutationFactor = 0, $mutationAmount = 1);

    /**
     * Individual constructor.
     *
     * @param TypeInterface $object
     *   The object to be wrapped by this individual.
     */
    public function __construct(TypeInterface $object)
    {
        $this->object = $object;
    }

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
