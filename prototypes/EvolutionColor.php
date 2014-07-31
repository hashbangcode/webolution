<?php
/**
 * Created by PhpStorm.
 * User: philipnorton
 * Date: 01/04/2014
 * Time: 20:06
 */

class EvolutionColor {

  protected $generation = 0;

  protected $maxGenerations = 20;

  protected $individualsPerGeneration = 5;

  protected $individuals;

  public function EvolutionColor($maxGenerations = 20, $individualsPerGeneration = 5) {
    $this->maxGenerations = $maxGenerations;
    $this->individualsPerGeneration = $individualsPerGeneration;
  }

  public function getFittest() {

  }

  public function runGeneration() {

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

    $this->generation++;
  }

  public function start() {
    $this->individuals = new ColorCollection();

    for ($i = 0; $i <= $this->individualsPerGeneration; ++$i) {
      $this->individuals->add(Color::generateFromHex('000000'));
    }

    $output = '';

    for ($i = 0; $i <= $this->maxGenerations; ++$i) {
      foreach ($this->individuals->getColors() as $color) {
        $output .= '<div style="background-color:#' . $color->getHex() . '";"></div>' . PHP_EOL;
      }
      $output .= '<br>' . PHP_EOL;
      $this->runGeneration();
    }

    foreach ($this->individuals->getColors() as $color) {
      $output .= '<div style="background-color:#' . $color->getHex() . '";"></div>' . PHP_EOL;
    }
    file_put_contents('evolve_test.html', $output);
  }
}