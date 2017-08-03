<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 03/08/2017
 * Time: 17:22
 */

namespace Kronhyx\BaseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package Kronhyx\BaseBundle\Controller
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class DefaultController extends MasterController
{

    /**
     * @Route()
     * @Template()
     */
    public function indexAction()
    {

        return [];
    }

}