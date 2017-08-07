<?php

namespace Kronhyx\BaseBundle\Base;

use AppBundle\Controller\AdminController;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class MenuBase
 * @package Kronhyx\BaseBundle\Base
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
abstract class MenuBase implements MenuBaseInterface
{
    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var MenuFactory $factory
     */
    protected $factory;

    /**
     * MenuBase constructor.
     * @param RouterInterface $router
     * @param MenuFactory $factory
     */
    public function __construct(RouterInterface $router, MenuFactory $factory)
    {
        $this->router = $router;
        $this->factory = $factory;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'kronhyx.base.menu.dispatch' => [
                ['getMenu', 10]
            ]
        ];
    }

    /**
     * @param Event $event
     * @return Event
     * @throws \ReflectionException
     */
    public function getMenu(Event $event)
    {
        /**
         * @var MenuItem $menu
         * @var MenuFactory $factory
         */
        /** @noinspection PhpUndefinedFieldInspection */
        $menu = $event->menu;

        $reflection = new \ReflectionClass($this);

        $item = new MenuItem($reflection->name, $this->factory);

        $item
            ->setLabel(\explode('\\', $reflection->name)[1])
            ->setUri(null)
            ->setAttributes([
                'icon' => $this->getIcon()
            ]);

        /**
         * @var \ReflectionMethod $method
         */
        foreach ($reflection->getMethods() as $method) {
            if ($method->class !== self::class && $method->getNumberOfParameters() === 1) {
                /** @noinspection PhpUndefinedFieldInspection */
                $item->addChild($method->invoke($this, $event->provider));
            }
        }

        $menu->addChild($item);

        return $event;
    }

}
