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
class KronhyxGlobalFunction extends \Twig_Extension
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
     * @var FormFactoryInterface $formFactory
     */
    private $formFactory;

    /**
     * @var null|Request $request
     */
    private $request;

    /**
     * @var array $menu
     */
    private $menu;

    /**
     * @var array $form
     */
    private $form;

    /**
     * KronhyxBundleFunction constructor.
     * @param EventDispatcherInterface $dispatcher
     * @param MenuFactory $factory
     * @param FormFactoryInterface $formFactory
     * @param RequestStack $stack
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function __construct(EventDispatcherInterface $dispatcher, MenuFactory $factory, FormFactoryInterface $formFactory, RequestStack $stack)
    {
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
        $this->formFactory = $formFactory;
        $this->request = $stack->getCurrentRequest();

        //Initialize Methods
        $this->getMenu();
        $this->getForm();
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        $functions = new ArrayCollection(parent::getFunctions());

        $donut = new \Twig_SimpleFunction('kronhyx_global',
            [$this, 'KronhyxGlobal'],
            [

            ]
        );

        $functions->add($donut);

        return $functions->toArray();
    }

    /**
     * @return array
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function KronhyxGlobal()
    {

        return [
            'menu' => $this->menu,
            'form' => $this->form
        ];
    }

    /**
     * @return KronhyxBundleFunction
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
        $this->menu = [
            'sidebar' => $sidebar->menu
        ];

        return $this;
    }

    /**
     * @return KronhyxBundleFunction
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    private function getForm()
    {
        $form = [
            'search' => $this->formFactory->create(SearchType::class)
        ];

        /**
         * @var FormInterface $item
         */
        foreach ($form as $name => $item) {
            if ($this->request instanceof Request) {
                $item->handleRequest($this->request);
            }
            $form[$name] = $item->createView();
        }

        $this->form = $form;

        return $this;
    }

}
