<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 08/08/2017
 * Time: 12:46
 */

namespace Kronhyx\BaseBundle\Event\Listener;

use Kronhyx\BaseBundle\Base\EventListenerBase;
use Kronhyx\BaseBundle\Controller\AuthController;
use Kronhyx\BaseBundle\Service\MenuService;
use Kronhyx\BaseBundle\Service\RecollectorService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class KernelListener
 * @package Kronhyx\BaseBundle\Event\Listener
 */
class KernelListener extends EventListenerBase
{

    /**
     * @var AuthorizationCheckerInterface $checker
     */
    private $checker;

    /**
     * @var TokenStorageInterface $storage
     */
    private $storage;

    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * @var \Twig_Environment $environment
     */
    private $twig;

    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * KernelListener constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;
        $this->checker = $this->container->get('security.authorization_checker');
        $this->storage = $this->container->get('security.token_storage');
        $this->router = $this->container->get('router');
        $this->twig = $this->container->get('twig');

    }

    /**
     * Comrprueba que esté logueado para acceder a la configuración del menú
     *
     * @param GetResponseEvent $event
     * @param string $name
     * @param TraceableEventDispatcher $dispatcher
     */
    public function checkPermission(GetResponseEvent $event, string $name, TraceableEventDispatcher $dispatcher)
    {
        $attributes = $event->getRequest()->attributes;
        $class = explode('::', $attributes->get('_controller'))[0];
        if (explode('\\', $class)[0] === 'Kronhyx') {
            $reflection = new \ReflectionClass($class);
            if (!$this->storage->getToken() instanceof UsernamePasswordToken && $attributes->get('exception') === null) {
                if (AuthController::class !== $reflection->name) {
                    return $event->setResponse(new RedirectResponse($this->router->generate('kronhyx_base_auth_login')));
                }
            }
        }
    }

    /**
     * Agrega las variables globales a Twig
     *
     * @param GetResponseEvent $event
     * @param string $name
     * @param TraceableEventDispatcher $dispatcher
     */
    public function addTwigGlobal(GetResponseEvent $event, string $name, TraceableEventDispatcher $dispatcher)
    {
        $recollector = $this->container->get(RecollectorService::class);

        $this->twig->addGlobal('kronhyx', [
            'form' => $recollector->getForm(),
            'menu' => $recollector->getMenu()
        ]);

    }

}