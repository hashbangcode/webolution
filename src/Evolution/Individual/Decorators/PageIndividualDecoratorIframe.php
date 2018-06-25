<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\IndividualFactory;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Class PageIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class PageIndividualDecoratorIframe extends PageIndividualDecoratorHtml
{
    /**
     * The type of rendering.
     *
     * @var string
     */
    protected $type = 'html';

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $pageHtml = parent::render();

        $iframe = '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $pageHtml . '\'></iframe>';

        // Return page markup.
        return $iframe;
    }
}
