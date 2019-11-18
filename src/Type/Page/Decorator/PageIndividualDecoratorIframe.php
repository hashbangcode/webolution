<?php

namespace Hashbangcode\Webolution\Type\Page\Decorator;

use Hashbangcode\Webolution\IndividualFactory;
use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Type\Element\Element;

/**
 * Class PageIndividualDecoratorIframe.
 *
 * @package Hashbangcode\Webolution\Type\Page\Decorator
 */
class PageIndividualDecoratorIframe extends PageIndividualDecoratorHtml
{

   /**
    * The height of the iframe.
    *
    * @var int
    */
    protected $height = 200;

    /**
     * The width of the iframe.
     *
     * @var int
     */
    protected $width = 200;

    /**
     * Get the height.
     *
     * @return int
     *   The height.
     */
    public function getHeight(): int
    {
      return $this->height;
    }

    /**
     * Set the height.
     *
     * @param int $height
     *   The height.
     */
    public function setHeight(int $height): void
    {
      $this->height = $height;
    }

    /**
     * Get the width.
     *
     * @return int
     *   The width.
     */
    public function getWidth(): int
    {
      return $this->width;
    }

    /**
     * Set the width.
     *
     * @param int $width
     *   The width.
     */
    public function setWidth(int $width): void
    {
      $this->width = $width;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $pageHtml = parent::render();

        $iframe = '<iframe class="elementframe" height="' . $this->getHeight() . '" width="' . $this->getWidth() . '" srcdoc=\'' . $pageHtml . '\'></iframe>';

        // Return page markup.
        return $iframe;
    }
}
