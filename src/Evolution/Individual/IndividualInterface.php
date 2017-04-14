<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;


interface IndividualInterface
{

    /**
     * @return mixed
     */
    public function getObject();

    /**
     * @return mixed
     */
    public function mutateProperties();

    /**
     * @return mixed
     */
    public function getFitness();

    /**
     * @param $renderType
     * @return mixed
     */
    public function render($renderType);
}