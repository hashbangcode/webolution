<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Type\TypeInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class Individual.
 *
 * @package Hashbangcode\Webolution\Individual
 */
abstract class Individual implements IndividualInterface
{
    /**
     * @var object The type object.
     */
    protected $object;

    /**
     * @var string the ID.
     */
    protected $id;

    /**
     * Generate the individual unique ID.
     *
     * @return string
     *   The ID.
     */
    protected function generateId()
    {
        $uuid1 = Uuid::uuid1();
        $this->setId($uuid1->toString());
    }

    /**
     * Get the ID.
     *
     * @return string
     *   The ID.
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Set the ID.
     *
     * @param string $id
     *   The ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getFitness($type = ''): float;

    /**
     * {@inheritdoc}
     */
    abstract public function mutate($mutationFactor = 0, $mutationAmount = 1);

    /**
     * Individual constructor.
     *
     * @param \Hashbangcode\Webolution\Type\TypeInterface $object
     *   The object to be wrapped by this individual.
     */
    public function __construct(TypeInterface $object)
    {
        // Generate an ID for this object.
        $this->generateId();

        // Set the object.
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
    public function getObject(): TypeInterface
    {
        return $this->object;
    }
}
