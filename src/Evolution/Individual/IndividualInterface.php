<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;


interface IndividualInterface {

  public function getObject();

  public function mutateProperties();

  public function getFitness();

  public function render();
}