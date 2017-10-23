<?php

namespace Kronhyx\BaseBundle\Base;

use AppBundle\Controller\AdminController;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
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
     * @var ArrayCollection $collection
     */
    protected $collection;

    /**
     * MenuBase constructor.
     * @param RouterInterface $router
     * @param MenuFactory $factory
     */
    public function __construct(RouterInterface $router, MenuFactory $factory)
    {
        $this->router = $router;
        $this->factory = $factory;
        $this->collection = new ArrayCollection();
        $this->router->setContext($context = new RequestContext(Request::createFromGlobals()->server->get('SCRIPT_NAME')));

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

        $name = \explode('\\', $reflection->name)[1];

        $item = new MenuItem($name, $this->factory);

        $item
            ->setLabel($name)
            ->setUri(null)
            ->setAttributes([
                'icon' => $reflection->getMethod('getIcon')->invoke($this)
            ]);

        /**
         * @var \ReflectionMethod $method
         */
        foreach ($reflection->getMethods() as $method) {
            if ($method->class !== self::class && $method->getNumberOfParameters() === 1) {

                $item->addChild($method->invoke($this, $event->provider));

            }
        }
        $menu->addChild($this->isCurrent($item));

        $this->collection->set($reflection->getMethod('getSpace')->invoke($this), $menu);

        $event->collection = $this->collection;

        return $event;
    }

    /**
     * @param MenuItem $item
     * @return MenuItem
     */
    protected function isCurrent(MenuItem $item)
    {
        $children = $item;
        while (!empty($children->getChildren())) {
            /**
             * @var MenuItem $child
             */
            foreach ($children as $child) {
                $children = $child;
                if ($child->getUri() === Request::createFromGlobals()->getRequestUri()) {
                    $child->setCurrent(true);

                    $parent = $child;
                    while ($parent->getParent()) {
                        if ($parent->getParent()) {
                            $parent = $parent->getParent();
                            $parent->setCurrent(true);
                        } else {
                            break;
                        }

                    }
                }

            }

        }

        return $item;
    }

}
