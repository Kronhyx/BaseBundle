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
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class KernelListener
 * @package Kronhyx\BaseBundle\Event\Listener
 */
class KernelListener extends EventListenerBase
{

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
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;
        $this->storage = $this->container->get('security.token_storage');
        $this->router = $this->container->get('router');
        $this->twig = $this->container->get('twig');

    }

    /**
     * Comrprueba que esté logueado para acceder a la configuración del menú
     *
     * @param GetResponseEvent $event
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \InvalidArgumentException
     * @throws \ReflectionException
     */
    public function checkPermission(GetResponseEvent $event)
    {
        $attributes = $event->getRequest()->attributes;
        $class = \explode('::', $attributes->get('_controller'))[0];
        if (\explode('\\', $class)[0] === 'Kronhyx') {
            $reflection = new \ReflectionClass($class);
            if (!$this->storage->getToken() instanceof UsernamePasswordToken && $attributes->get('exception') === null) {
                if (AuthController::class !== $reflection->name) {
                    return $event->setResponse(new RedirectResponse($this->router->generate('kronhyx_base_auth_login')));
                }
            } else {
                if (AuthController::class === $reflection->name) {
                    return $event->setResponse(new RedirectResponse($this->router->generate('kronhyx_base_main_dashboard')));
                }
            }
        }

        return $event->getResponse();
    }

    /**
     * Agrega las variables globales a Twig
     *
     * @param GetResponseEvent $event
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function addTwigGlobal(GetResponseEvent $event)
    {
        $recollector = $this->container->get(RecollectorService::class);

        $this->twig->addGlobal('kronhyx', [
            'form' => $recollector->getForm(),
            'menu' => $recollector->getMenu()
        ]);

    }

}