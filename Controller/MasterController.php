<?php

namespace Kronhyx\BaseBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
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
     * @var FormFactoryInterface $form
     */
    protected $form;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var Session $session
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

    /**
     * @param EntityManagerInterface $manager
     * @return MasterController
     */
    public function setManager(EntityManagerInterface $manager): MasterController
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $form
     * @return MasterController
     */
    public function setForm(FormFactoryInterface $form): MasterController
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return MasterController
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): MasterController
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return MasterController
     */
    public function setRouter(RouterInterface $router): MasterController
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param Session $session
     * @return MasterController
     */
    public function setSession(Session $session): MasterController
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @param TokenStorageInterface $storage
     * @return MasterController
     */
    public function setStorage(TokenStorageInterface $storage): MasterController
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @param RequestStack $stack
     * @return MasterController
     */
    public function setRequest(RequestStack $stack): MasterController
    {
        $this->request = $stack->getCurrentRequest();
        return $this;
    }

}
