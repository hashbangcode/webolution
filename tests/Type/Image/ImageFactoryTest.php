<?php

namespace Hashbangcode\Webolution\Test\Type\Image;

use Hashbangcode\Webolution\Type\Image\Image;
use Hashbangcode\Webolution\Type\Image\ImageFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ImageFactory.
 */
class ImageFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $object = ImageFactory::generateRandom();
        $this->assertInstanceOf(Image::class, $object);
    }
}
