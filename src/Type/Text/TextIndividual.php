<?php

namespace Hashbangcode\Webolution\Type\Text;

use Hashbangcode\Webolution\Individual;
use Hashbangcode\Webolution\Generator\RandomText;

/**
 * Class TextIndividual
 * @package Hashbangcode\Webolution\Individual
 */
class TextIndividual extends Individual
{
    use RandomText;

    /**
     * @var string The fitness goal that the string should aspire to.
     */
    protected $fitnessGoal = '';

    /**
     * Generate a new TextIndividual.
     *
     * @return TextIndividual
     *   The new TextIndividual.
     */
    public static function generateRandomTextIndividual($length = 10)
    {
        $textObject = TextFactory::generateRandomWithLength($length);
        return new self($textObject);
    }

    /**
     * @param string $string
     *   The text string to use.
     *
     * @return TextIndividual
     */
    public static function generateFromString($string)
    {
        $textObject = TextFactory::generateFromString($string);
        return new self($textObject);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        // The name of the TextIndividual is the text value.
        return $this->getObject()->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getSpecies(): string
    {
        // The species of the TextIndividual is the crc32 hash value of the string.
        return (string) crc32($this->getObject()->getText());
    }

    /**
     * {@inheritdoc}
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $text = $this->getObject()->getText();
        $goal = $this->getFitnessGoal();

        $text_length = strlen($text);
        $goal_length = strlen($goal);

        $action = mt_rand(0, 100);
        if ($action < 1 && $text_length != $goal_length) {
            $operators = ['add', 'subtract'];

            switch ($operators[array_rand($operators)]) {
                case 'add':
                    // Add a random letter.
                    $this->getObject()->setText($text . $this->getRandomLetter());
                    break;
                case 'subtract':
                    // Remove a random letter.
                    $letter_position = mt_rand(0, strlen($text) - 1);
                    $text_array = str_split($this->getObject()->getText());
                    unset($text_array[$letter_position]);
                    $this->getObject()->setText(implode('', $text_array));
                    break;
            }
        } else {
            // Mutate a single letter from the text.
            $this->mutateSingleLetter();
        }
    }

    /**
     * Mutate a single letter.
     */
    public function mutateSingleLetter()
    {
        // Extract text and goals.
        $text = $this->getObject()->getText();
        $goal = $this->getFitnessGoal();

        // Get a random letter from the current string.
        $letter_position = mt_rand(0, strlen($text) - 1);

        // Extract the single letter.
        $text = str_split($text);
        $letter = $text[$letter_position];

        // If the letter we extract is the same as the goal then don't mutate.
        $goal = str_split($goal);
        if (isset($goal[$letter_position]) && $goal[$letter_position] == $letter) {
            return;
        }

        // Select a new letter.
        if ($letter == 'z') {
            $newletter = 'A';
        } elseif ($letter == 'Z') {
            $newletter = ' ';
        } elseif ($letter == ' ') {
            $newletter = 'a';
        } else {
            $newletter = chr(ord($letter) + 1);
        }

        // Swap it for a random letter.
        $text[$letter_position] = $newletter;

        // Re-create the text string and set it back to the object.
        $text = implode('', $text);
        $this->getObject()->setText($text);
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = ''): float
    {
        // Get the text and the fitness goal values.
        $text = str_split($this->getObject()->getText());
        $goal = str_split($this->getFitnessGoal());

        $score = 0;

        // Count the number of characters that are the same as our goal text.
        foreach ($text as $index => $character) {
            if (isset($goal[$index]) && $goal[$index] == $character) {
                $score = $score + 1;
            }
        }

        return $score;
    }

    /**
     * Get the fitness goal.
     *
     * @return mixed
     *   Get the fitness goal.
     */
    public function getFitnessGoal()
    {
        return $this->fitnessGoal;
    }

    /**
     * Set the fitness goal.
     *
     * @param mixed $fitnessGoal
     *   The fitness goal.
     */
    public function setFitnessGoal($fitnessGoal)
    {
        $this->fitnessGoal = $fitnessGoal;
    }
}
