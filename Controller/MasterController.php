<?php

namespace Kronhyx\BaseBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class MasterController
 * @package Kronhyx\BaseBundle\Controller
 */
class MasterController extends Controller
{
    /**
     * @var EntityManagerInterface $manager
     */
    protected $manager;

    /**
     * @var FormFactoryInterface $factory
     */
    protected $factory;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var SessionInterface $session
     */
    protected $session;

    /**
     * @var TokenStorageInterface $storage
     */
    protected $storage;

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * MasterController constructor.
     * @param EntityManagerInterface $manager
     * @param RouterInterface $router
     * @param EventDispatcherInterface $dispatcher
     * @param FormFactoryInterface $factory
     * @param SessionInterface $session
     * @param RequestStack $stack
     * @param TokenStorageInterface $storage
     */
    public function __construct(EntityManagerInterface $manager, RouterInterface $router, EventDispatcherInterface $dispatcher, FormFactoryInterface $factory, SessionInterface $session, RequestStack $stack, TokenStorageInterface $storage)
    {
        $this->manager = $manager;
        $this->router = $router;
        $this->dispatcher = $dispatcher;
        $this->form = $factory;
        $this->session = $session;
        $this->request = $stack->getCurrentRequest();
        $this->storage = $storage;
    }
}
