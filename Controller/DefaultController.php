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
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package Kronhyx\BaseBundle\Controller
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class DefaultController extends ControllerBase
{

    /**
     * @Route()
     * @Template()
     */
    public function indexAction()
    {
        $event = new Event();
        $event->provider = $this->get('knp_menu.factory');
        $event->menu = $this->get('knp_menu.factory')->createItem('sidebar');

        $this->get('event_dispatcher')->dispatch('kronhyx.base.menu.dispatch', $event);

//        exit(dump($event->menu));
        return [
            'sidebar' => $event->menu
        ];

    }

}