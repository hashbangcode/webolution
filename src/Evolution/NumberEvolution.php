<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

class NumberEvolution extends Evolution {

  public function __construct() {

  }

  public function runGeneration() {

    if ($this->generation == 0) {
      for ($i = 1; $i <= $this->individualsPerGeneration; ++$i) {
        $number = rand(1, 10);
        $this->individuals[] = new NumberIndividual($number);
      }
    }

    $this->previousGenerations[] = $this->individuals;

    echo ' start ';

    foreach ($this->individuals as $key => $individual) {
      print $individual->getObject()->getNumber() . ' ';
    }

    if (count($this->individuals) <= $this->individualsPerGeneration) {
      echo ' more ';
      echo ' (' . count($this->individuals) . '[' .$this->individualsPerGeneration.'] ) ';
      do {
        $number = rand(1, 10);
        $this->individuals[] = new NumberIndividual($number);
      } while (count($this->individuals) <= $this->individualsPerGeneration);
      echo ' (' . count($this->individuals) . ') ';

    }

    foreach ($this->individuals as $individual) {
      $individual->mutateProperties();
    }

    foreach ($this->individuals as $key => $individual) {
      if ($individual->getFitness() < 8) {
        //echo 'killed! ' . $individual->getFitness();
        unset($this->individuals[$key]);
      }
    }

    echo ' end ';
    foreach ($this->individuals as $key => $individual) {
      print $individual->getObject()->getNumber() . ' ';
    }

    $this->generation++;

/*
    $colors = $this->individuals->getColors();

    $new_colors = array();

    foreach ($colors as $color) {
      $new_color = Color::generateFromHex($color->getHex());
      $new_color->mutateColor(50);
      $new_colors[] = $new_color;
    }

    foreach ($new_colors as $color) {
      $this->individuals->add($color);
    }

    $this->individuals->sort();//'hsi_saturation', 'DESC');

    $tmp_individuals = new ColorCollection();

    $count = 0;
    foreach ($this->individuals->getColors() as $color) {
      $tmp_individuals->add($color);
      ++$count;
      if ($count > $this->individualsPerGeneration) {
        break;
      }
    }

    $this->individuals = $tmp_individuals;
*/

  }
}