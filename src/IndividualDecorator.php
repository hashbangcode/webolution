<?php

namespace Hashbangcode\Webolution;

/**
 * Class IndividualDecorator.
 *
 * @package \Hashbangcode\Webolution
 */
abstract class IndividualDecorator implements IndividualDecoratorInterface
{
    /**
     * @var \Hashbangcode\Webolution\IndividualInterface The Individual object.
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
