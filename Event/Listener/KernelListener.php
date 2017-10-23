<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 08/08/2017
 * Time: 12:46
 */

namespace Kronhyx\BaseBundle\Event\Listener;

use Kronhyx\BaseBundle\Base\EventListenerBase;
use Kronhyx\BaseBundle\Service\MenuService;
use Kronhyx\BaseBundle\Service\RecollectorService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
            'form' => $recollector->getForm()->map(function ($form) {
                return $form->createView();
            }),
            'menu' => $recollector->getMenu()->toArray()
        ]);

    }

}