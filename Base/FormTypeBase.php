<?php

namespace Kronhyx\BaseBundle\Base;

use AppBundle\Controller\AdminController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormTypeBase
 * @package Kronhyx\BaseBundle\Base
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
abstract class FormTypeBase extends AbstractType implements FormTypeBaseInterface
{
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
     * @throws \ReflectionException
     */
    public function getType(Event $event)
    {

        /**
         * @var FormFactoryInterface $factory
         * @var ArrayCollection $collection
         */
        $factory = $event->factory;
        $collection = $event->collection;

        $reflection = new \ReflectionClass($this);

        $form = $factory->create($reflection->name);

        $form->handleRequest(Request::createFromGlobals());

        $name = new ArrayCollection(explode('\\', $reflection->name));

        $collection->set(mb_strtolower(str_replace('Type', null, $name->last())), $form->createView());

        return $event;
    }


}
