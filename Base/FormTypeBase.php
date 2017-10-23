<?php

namespace Kronhyx\BaseBundle\Base;

use AppBundle\Controller\AdminController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class FormTypeBase
 * @package Kronhyx\BaseBundle\Base
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
abstract class FormTypeBase extends AbstractType implements FormTypeBaseInterface
{
    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * FormTypeBase constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'kronhyx.base.form.dispatch' => [
                ['getType', 10]
            ]
        ];
    }

    /**
     * @param Event $event
     * @return Event
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \ReflectionException
     */
    public function getType(GenericEvent $event)
    {
        /**
         * @var FormFactoryInterface $factory
         * @var ArrayCollection $collection
         */
        $factory = $event->getArgument('factory');
        $collection = $event->getArgument('collection');

        $reflection = new \ReflectionClass($this);

        $form = $factory->createBuilder($reflection->name)
            ->setAction($this->getAction())
            ->setMethod($this->getMethod())
            ->getForm();

        $name = new ArrayCollection(\explode('\\', $reflection->name));

        $collection->set(mb_strtolower(\str_replace('Type', null, $name->last())), $form);

        return $event;
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    protected function getAction()
    {
        return $this->router->generate('kronhyx_base_main_dashboard');
    }
}
