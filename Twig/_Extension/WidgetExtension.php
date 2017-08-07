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
     * @var \Twig_Environment $environment
     */
    private $environment;

    /**
     * WidgetExtension constructor.
     * @param \Twig_Environment $environment
     */
    public function __construct(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

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
                'needs_environment' => true,
            ]
        );

        $functions->add($donut);

        return $functions->toArray();
    }

    /**
     * @param array $data
     * @param array $colors
     * @param array $options
     * @return string
     */
    public function donut(\Twig_Environment $environment, array $data, array $color = [], array $options = [])
    {
        return $environment->render('@KronhyxBase/_widgets/donut.html.twig', [
            'donut' => [
                'name' => 'kronhyx_widget_donut_' . uniqid(),
                'data' => $data,
                'color' => $color,
                'options' => $options,
            ],
        ]);
    }

}
