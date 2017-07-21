<?php

namespace Kronhyx\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class MasterController
 * @package Kronhyx\BaseBundle\Controller
 */
class MasterController extends Controller
{
    /**
     * @var \Doctrine\ORM\EntityManager $manager
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
     * @var SessionInterface $session
     */
    protected $session;

    /**
     * @var TokenInterface $token
     */
    protected $token;

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * MasterController constructor.
     * @param ContainerInterface $container
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->manager = $container->get('doctrine.orm.entity_manager');
        $this->router = $container->get('router');
        $this->dispatcher = $container->get('event_dispatcher');
        $this->form = $container->get('form.factory');
        $this->session = $container->get('session');
        $this->request = $container->get('request_stack')->getCurrentRequest();
        $this->token = $container->get('security.token_storage')->getToken();
    }
}
