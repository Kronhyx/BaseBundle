<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 03/08/2017
 * Time: 17:22
 */

namespace Kronhyx\BaseBundle\Controller;

use Kronhyx\BaseBundle\Base\ControllerBase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package Kronhyx\BaseBundle\Controller
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class AuthController extends ControllerBase
{

    /**
     * @Route("login.php/")
     * @Template("@KronhyxBase/Auth/login.html.twig")
     *
     * @return array
     *
     */
    public function loginAction()
    {

        return [];

    }

    /**
     * @Route("recover.php/")
     * @Template("@KronhyxBase/Auth/recover.html.twig")
     *
     * @return array
     *
     */
    public function recoverAction()
    {

        return [];

    }

    /**
     * @Route("register.php/")
     * @Template("@KronhyxBase/Auth/register.html.twig")
     *
     * @return array
     *
     */
    public function registerAction()
    {

        return [];

    }

}