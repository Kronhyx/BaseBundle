<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 09/08/2017
 * Time: 11:18
 */

namespace Kronhyx\BaseBundle\Base;


use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ServiceBase
 * @package Kronhyx\BaseBundle\Base
 */
abstract class ServiceBase
{
    use ContainerAwareTrait;
}