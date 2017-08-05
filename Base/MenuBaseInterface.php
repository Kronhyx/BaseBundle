<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 04/08/2017
 * Time: 11:21 PM
 */

namespace Kronhyx\BaseBundle\Base;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface MenuBaseInterface
 * @package Kronhyx\BaseBundle\Base
 */
interface MenuBaseInterface extends EventSubscriberInterface
{
    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return string
     */
    public function getUri();
}