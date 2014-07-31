<?php
/**
 * Created by PhpStorm.
 * User: philipnorton
 * Date: 01/04/2014
 * Time: 20:06
 */

abstract class Evolution {

  protected $generation = 0;

  protected $maxGenerations = 20;

  public function Evolution($maxGenerations) {
    $this->$maxGenerations = $maxGenerations;
  }

  public function runGeneration() {
    $this->generation++;

  }
}