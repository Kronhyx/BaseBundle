<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 13/01/2017
 * Time: 11:49 AM.
 */

namespace Kronhyx\BaseBundle\Base;

use AppBundle\Controller\AdminController;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class MenuBase
 * @package Kronhyx\BaseBundle\Base
 */
abstract class MenuBase implements MenuBaseInterface
{

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
        /** @noinspection PhpUndefinedFieldInspection */
        $factory = $event->provider;
        $reflection = new \ReflectionClass($this);

        $item = new MenuItem($reflection->name, $factory);

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
