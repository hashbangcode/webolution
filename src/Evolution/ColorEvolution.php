<?php

namespace Hashbangcode\Wevolution\Evolution;

class ColorEvolution extends Evolution {

  protected $generation = 0;

  protected $maxGenerations = 20;

  protected $individualsPerGeneration = 5;

  protected $individuals;

  public function runGeneration() {
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
    $this->generation++;
  }
}