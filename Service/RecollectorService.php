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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
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
    }

    /**
     * @return ArrayCollection
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    public function getMenu()
    {
        $event = new GenericEvent();

        $event->setArgument('provider', $this->container->get('knp_menu.factory'));
        $event->setArgument('menu', $event->getArgument('provider')->createItem('menu'));
        $event->setArgument('collection', new ArrayCollection());

        $this->dispatcher->dispatch('kronhyx.base.menu.dispatch', $event);
        return $event->getArgument('collection');
    }

    /**
     * @param string|null $form
     * @return ArrayCollection|Form
     */
    public function getForm(string $form = null)
    {
        $event = new GenericEvent();

        $event->setArgument('factory', $this->factory);
        $event->setArgument('collection', new ArrayCollection());

        $this->dispatcher->dispatch('kronhyx.base.form.dispatch', $event);

        if ($form) {
            /**
             * @var Form $item
             */
            foreach ($event->getArgument('collection')->toArray() as $key => $item) {
                if ($item instanceof Form && $form === $key) {
                    return $item;
                }
            }
        }

        return $event->getArgument('collection');
    }

}