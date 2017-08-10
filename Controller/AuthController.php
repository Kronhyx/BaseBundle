<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 03/08/2017
 * Time: 17:22
 */

namespace Kronhyx\BaseBundle\Controller;

use Kronhyx\BaseBundle\Base\ControllerBase;
use Kronhyx\BaseBundle\Service\RecollectorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return array
     */
    public function loginAction(Request $request)
    {

        return [];

    }

    /**
     * @Route("recover.php/")
     * @Template("@KronhyxBase/Auth/recover.html.twig")
     *
     * @param Request $request
     * @return array|string
     */
    public function recoverAction(Request $request)
    {
        $form = $this->get(RecollectorService::class)->getForm('recover')->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $this->render('@KronhyxBase/Auth/recoverConfirm.html.twig', [
                'data' => $form->getData()
            ]);
        }

        return [];

    }

    /**
     * @Route("register.php/")
     * @Template("@KronhyxBase/Auth/register.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function registerAction(Request $request)
    {

        return [];

    }

}