<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 13/01/2017
 * Time: 11:49 AM.
 */

namespace Kronhyx\BaseBundle\Menu;

use AppBundle\Controller\AdminController;
use Knp\Menu\FactoryInterface;
use Kronhyx\BaseBundle\Base\MenuBase;

/**
 * Class TableMenu
 * @package Kronhyx\BaseBundle\Menu
 */
class TableMenu extends MenuBase
{

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Table';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'zmdi zmdi-view-list';
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this;
    }

    /**
     * @param FactoryInterface $factory
     * @return \Knp\Menu\ItemInterface
     * @throws \InvalidArgumentException
     */
    public function Cards(FactoryInterface $factory)
    {
        $menu = $factory->createItem(__FUNCTION__);
        $menu
            ->setName(__FUNCTION__)
            ->setLabel(__FUNCTION__);

        return $menu;
    }

    /**
     * @param FactoryInterface $factory
     * @return \Knp\Menu\ItemInterface
     * @throws \InvalidArgumentException
     */
    public function FontAwesome(FactoryInterface $factory)
    {
        $menu = $factory->createItem(__FUNCTION__);
        $menu
            ->setName(__FUNCTION__)
            ->setLabel(__FUNCTION__);

        return $menu;
    }

}
