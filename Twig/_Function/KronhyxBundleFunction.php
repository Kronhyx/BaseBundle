<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 12/06/2016
 * Time: 1:24 PM.
 */

namespace Kronhyx\BaseBundle\Twig\_Function;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\MenuFactory;
use Kronhyx\BaseBundle\Form\Type\SearchType;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class DateTimeExtension
 * @package Kronhyx\BaseBundle\Twig\_Extension
 * @author Randy Téllez <kronhyx@gmail.com>
 */
class KronhyxBundleFunction extends \Twig_Extension
{
    /**
     * @var MenuFactory $factory
     */
    private $factory;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @var FormFactoryInterface $form
     */
    private $form;

    /**
     * @var null|Request $request
     */
    private $request;

    /**
     * KronhyxBundleFunction constructor.
     * @param EventDispatcherInterface $dispatcher
     * @param MenuFactory $factory
     * @param FormFactoryInterface $form
     * @param RequestStack $stack
     */
    public function __construct(EventDispatcherInterface $dispatcher, MenuFactory $factory, FormFactoryInterface $form, RequestStack $stack)
    {
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
        $this->form = $form;
        $this->request = $stack->getCurrentRequest();
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        $functions = new ArrayCollection(parent::getFunctions());

        $functions->add(new \Twig_SimpleFunction('KronhyxBundle', [
            $this, 'KronhyxBundle'
        ]));

        return $functions->toArray();
    }

    /**
     * @return array
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function KronhyxBundle()
    {
        return [
            'menu' => $this->getMenu(),
            'form' => $this->getForm()
        ];
    }

    /**
     * @return array
     */
    private function getMenu()
    {
        $sidebar = new Event();

        /** @noinspection PhpUndefinedFieldInspection */
        $sidebar->provider = $this->factory;

        /** @noinspection PhpUndefinedFieldInspection */
        $sidebar->menu = $this->factory->createItem('sidebar');

        $this->dispatcher->dispatch('kronhyx.base.menu.dispatch', $sidebar);

        /** @noinspection PhpUndefinedFieldInspection */
        return [
            'sidebar' => $sidebar->menu
        ];
    }


    /**
     * @return array
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    private function getForm()
    {
        $form = [
            'search' => $this->form->create(SearchType::class)
        ];

        /**
         * @var FormInterface $item
         */
        foreach ($form as $name => $item) {
            $form[$name] = $item->handleRequest($this->request)->createView();
        }

        return $form;
    }

}
