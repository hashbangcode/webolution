<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

interface PopulationInterface
{

    /**
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|NULL $individual
     * @return mixed
     */
    public function addIndividual(Individual $individual = NULL);

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