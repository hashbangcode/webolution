<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

interface PopulationInterface
{

    /**
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $individual
     * @return mixed
     */
    public function addIndividual(Individual $individual = null);

    /**
     * @return mixed
     */
    public function sort();

    /**
     * @return mixed
     */
    public function getLength();

    /**
     * @return mixed
     */
    public function getIndividuals();

    /**
     * @return mixed
     */
    public function render();
}