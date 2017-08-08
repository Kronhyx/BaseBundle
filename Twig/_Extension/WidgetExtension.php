<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 12/06/2016
 * Time: 1:24 PM.
 */

namespace Kronhyx\BaseBundle\Twig\_Extension;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class WidgetExtension
 * @package Kronhyx\BaseBundle\Twig\_Extension
 * @author Randy Téllez <kronhyx@gmail.com>
 */
class WidgetExtension extends \Twig_Extension
{

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        $functions = new ArrayCollection(parent::getFunctions());

        $donut = new \Twig_SimpleFunction('kronhyx_widget_donut',
            [$this, 'donut'],
            [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]
        );

        $functions->add($donut);

        return $functions->toArray();
    }

    /**
     * @param \Twig_Environment $environment
     * @param array $data
     * @param array $options
     * @return string
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     */
    public function donut(\Twig_Environment $environment, array $data, array $options = [])
    {
        return $environment->render('@KronhyxBase/_widgets/donut.html.twig', [
            'donut' => [
                'name' => \uniqid('kronhyx_widget_donut_', true),
                'data' => $data,
                'options' => $options
            ]
        ]);
    }

}
