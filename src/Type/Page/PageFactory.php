<?php

namespace Hashbangcode\Webolution\Type\Page;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\TypeFactoryInterface;
use Hashbangcode\Webolution\Type\Page\Page;

/**
 * Class PageFactory.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class PageFactory implements TypeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function generateRandom(): TypeInterface
    {
        $page = new Page();
        return $page;
    }
}
