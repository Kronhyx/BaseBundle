<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 03/08/2017
 * Time: 17:22
 */

namespace Kronhyx\BaseBundle\Controller;

use Kronhyx\BaseBundle\Base\ControllerBase;
use Kronhyx\BaseBundle\Form\Type\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package Kronhyx\BaseBundle\Controller
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class MainController extends ControllerBase
{

    /**
     * @Route()
     * @Template("@KronhyxBase/Main/dashboard.html.twig")
     *
     * @param Request $request
     * @return array
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function dashboardAction(Request $request)
    {
        $event = new Event();

        $event->provider = $this->get('knp_menu.factory');
        $event->menu = $this->get('knp_menu.factory')->createItem('sidebar');

        $this->dispatcher->dispatch('kronhyx.base.menu.dispatch', $event);

        $form = $this->form->create(SearchType::class);

        $form->handleRequest($request);

        return [
            'sidebar' => $event->menu,
            'form' => $form->createView()
        ];

    }

}