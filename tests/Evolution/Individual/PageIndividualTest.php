<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;

/**
 * Test class for PageIndividual
 */
class PageIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = new PageIndividual();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual', $object);
    }

    public function testCreateFullIndividual()
    {
        $object = new PageIndividual();

        $style = new \Hashbangcode\Wevolution\Type\Style\Style('div');
        $style->setAttribute('color', 'red');
        $object->getObject()->setStyle($style);

        $body = new \Hashbangcode\Wevolution\Type\Element\Element('div');
        $object->getObject()->setBody($body);

        $output = $object->getObject()->render();

        $this->assertStringEqualsFile('tests/Evolution/Individual/data/page01.html', $output);
    }
}
