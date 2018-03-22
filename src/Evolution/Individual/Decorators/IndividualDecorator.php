<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\IndividualInterface;

/**
 * Class IndividualDecorator.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
abstract class IndividualDecorator implements IndividualDecoratorInterface
{

    /**
     * The individual object.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Individual\IndividualInterface
     */
    protected $individual;

    /**
     * Get the individual.
     *
     * @return IndividualInterface
     *   The individual.
     */
    public function getIndividual(): IndividualInterface
    {
        return $this->individual;
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(IndividualInterface $individual)
    {
        $this->individual = $individual;
    }
}
