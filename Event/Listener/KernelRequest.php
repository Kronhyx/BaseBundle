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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class KernelRequest extends EventListenerBase
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
     * KernelRequest constructor.
     * @param AuthorizationCheckerInterface $checker
     * @param TokenStorageInterface $storage
     * @param RouterInterface $router
     */
    public function __construct(AuthorizationCheckerInterface $checker, TokenStorageInterface $storage, RouterInterface $router)
    {
        $this->checker = $checker;
        $this->storage = $storage;
        $this->router = $router;
    }

    /**
     * Comrprueba que esté logueado para acceder a la configuración del menú
     *
     * @param GetResponseEvent $event
     * @param string $listener
     * @param TraceableEventDispatcher $dispatcher
     */
    public function checkPermission(GetResponseEvent $event, string $listener, TraceableEventDispatcher $dispatcher)
    {
        $attributes = $event->getRequest()->attributes;
        if (!$this->storage->getToken() instanceof UsernamePasswordToken && $attributes->get('exception') === null) {
            if (AuthController::class !== explode('::', $attributes->get('_controller'))[0]) {
                exit(dump($this->storage, AuthController::class, $event->getRequest(), explode('::', $attributes->get('_controller'))[0]));
                return $event->setResponse(new RedirectResponse($this->router->generate('kronhyx_base_auth_login')));
            }
        }
    }

}