<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 09/08/2017
 * Time: 11:17
 */

namespace Kronhyx\BaseBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Kronhyx\BaseBundle\Base\ServiceBase;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class RecollectorService
 * @package Kronhyx\BaseBundle\Service
 */
class RecollectorService extends ServiceBase
{

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @var FormFactoryInterface $form
     */
    protected $factory;

    /**
     * @var ArrayCollection $collection
     */
    protected $collection;

    /**
     * RecollectorService constructor.
     * @param EventDispatcherInterface $dispatcher
     * @param FormFactoryInterface $factory
     */
    public function __construct(EventDispatcherInterface $dispatcher, FormFactoryInterface $factory)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->collection = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    public function getMenu()
    {
        $event = new Event();

        /** @noinspection PhpUndefinedFieldInspection */
        $event->provider = $this->container->get('knp_menu.factory');

        /** @noinspection PhpUndefinedFieldInspection */
        $event->menu = $event->provider->createItem('menu');

        $this->dispatcher->dispatch('kronhyx.base.menu.dispatch', $event);

        $this->collection = $event->collection;

        return $this->collection;
    }

    /**
     * @param string|null $form
     * @return ArrayCollection|Form
     */
    public function getForm(string $form = null)
    {
        $event = new Event();
        $event->factory = $this->factory;
        $event->collection = $this->collection;

        $this->dispatcher->dispatch('kronhyx.base.form.dispatch', $event);

        $this->form = $event->collection;

        if ($form) {
            /**
             * @var Form $item
             */
            foreach ($event->collection->toArray() as $key => $item) {
                if ($item instanceof Form && $form === $key) {
                    return $item;
                }
            }
        }

        return $this->form;
    }

}