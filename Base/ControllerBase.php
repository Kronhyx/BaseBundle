<?php

namespace Kronhyx\BaseBundle\Base;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("base/")
 *
 * Class MasterController
 * @package Kronhyx\BaseBundle\Controller
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
abstract class ControllerBase extends Controller
{
    /**
     * @var EntityManagerInterface $manager
     */
    protected $manager;

    /**
     * @var FormFactoryInterface $form
     */
    protected $form;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * ControllerBase constructor.
     * @param EntityManagerInterface $manager
     * @param FormFactoryInterface $form
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManagerInterface $manager, FormFactoryInterface $form, EventDispatcherInterface $dispatcher)
    {
        $this->manager = $manager;
        $this->form = $form;
        $this->dispatcher = $dispatcher;
    }

}
