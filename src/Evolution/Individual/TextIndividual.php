<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Text\Text;

/**
 * Class TextIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class TextIndividual extends Individual {

  protected $textLength = 10;

  protected $fitnessGoal;

  /**
   * TextIndividual constructor.
   * @param $text
   */
  public function __construct($text) {
    $this->object = new Text($text);
  }

  /**
   * @return \Hashbangcode\Wevolution\Evolution\Individual\TextIndividual
   */
  public static function generateRandomText() {
    $text = "";
    $textLength = 7;
    $charArray = array_merge(range('a', 'z'), range('A', 'Z'), [' ']);
    for ($i = 0; $i < $textLength; $i++) {
      $randItem = array_rand($charArray);
      $text .= $charArray[$randItem];
    }
    return new TextIndividual($text);
  }

  /**
   *
   */
  public function mutateProperties() {
    if ((mt_rand(0, 1000) / 1000) < $this->getMutationFactor()) {
      $this->getObject()->mutateText();
    }
  }

  /**
   * @return mixed
   */
  public function getFitness() {
    $text = str_split($this->getObject()->getText());

    $goal = str_split($this->getFitnessGoal());

    $score = 0;

    foreach ($text as $index => $character) {
      if (isset($goal[$index]) && $goal[$index] == $character) {
        $score = $score + 1;
      }
    }

    return $score;
  }

  /**
   * @return mixed
   */
  public function getFitnessGoal() {
    return $this->fitnessGoal;
  }

  /**
   * @param mixed $fitnessGoal
   */
  public function setFitnessGoal($fitnessGoal) {
    $this->fitnessGoal = $fitnessGoal;
  }

  /**
   * @param $renderType
   * @return mixed
   */
  public function render($renderType = 'cli') {
    switch ($renderType) {
      case 'html':
        return $this->object->render() . '<br>';
      case 'cli':
      default:
        return $this->object->render() . ' ';
    }
  }
}