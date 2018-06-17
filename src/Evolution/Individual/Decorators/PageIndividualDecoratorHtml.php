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
class PageIndividualDecoratorHtml extends IndividualDecorator
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
        // Grab the object.
        $object = $this->getIndividual()->getObject();

        // Set up output variables.
        $style = '';
        $body = '';

        // Render the styles.
        if (count($object->getStyles()) > 0) {
            foreach ($object->getStyles() as $styleObject) {
                if ($styleObject instanceof Style) {
                    $styleIndividual = IndividualFactory::getIndividual($styleObject);
                    $decorator = IndividualDecoratorFactory::getIndividualDecorator($styleIndividual, $this->type);

                    $style .= PHP_EOL . '        ' . $decorator->render();
                }
            }
            // Wrap the style in tags.
            $style = '    <style>' . $style . PHP_EOL . '    </style>' . PHP_EOL;
        }

        // Render the body.
        if ($object->getBody() instanceof Element) {
            $elementIndividual = IndividualFactory::getIndividual($object->getBody());
            $decorator = IndividualDecoratorFactory::getIndividualDecorator($elementIndividual, $this->type);

            $body .= $decorator->render() . PHP_EOL;
        }

        // Put the pieces together.
        $html = '<!DOCTYPE html>' . PHP_EOL;
        $html .= '<html>' . PHP_EOL;
        $html .= '<head>' . PHP_EOL;
        $html .= '    <meta charset="utf-8"/>' . PHP_EOL;
        $html .= $style;
        $html .= '</head>' . PHP_EOL;
        $html .= '<body>' . PHP_EOL;
        $html .= $body;
        $html .= '</body>' . PHP_EOL;
        $html .= '</html>';

        // Return page markup.
        return $html;
    }
}