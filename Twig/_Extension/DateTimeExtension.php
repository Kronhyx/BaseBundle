<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 12/06/2016
 * Time: 1:24 PM.
 */

namespace Kronhyx\BaseBundle\Twig\_Extension;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class DateTimeExtension
 * @package Kronhyx\BaseBundle\Twig\_Extension
 * @author Randy Téllez <kronhyx@gmail.com>
 */
class DateTimeExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        $filters = new ArrayCollection(parent::getFilters());

        $filters->add(new \Twig_SimpleFilter('kronhyx_timeAgo', [
            $this, 'timeAgo'
        ]));


        return $filters->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        $functions = new ArrayCollection(parent::getFunctions());

        $functions->add(new \Twig_SimpleFunction('kronhyx_timeAgo', [
            $this, 'timeAgo'
        ]));

        return $functions->toArray();
    }

    /**
     * @param \DateTime|null $after
     * @param \DateTime|null $before
     * @return string
     */
    public function timeAgo(\DateTime $after = null, \DateTime $before = null)
    {
        //Compruebo que exista una fecha antigua
        $after = $after ?? new \DateTime();
        $before = $before ?? new \DateTime();

        //Obtengo el intervalo entre la fecha del numero y la fecha actual
        $interval = $after->diff($before);

        //Obtengo el intervalo desglosado
        $fecha = [
            'year' => $interval->y, //Cantidad de annos,
            'month' => $interval->m, //Cantidad de meses,
            'day' => $interval->d, //Cantidad de dias,
            'hour' => $interval->h, //Cantidad de horas,
            'min' => $interval->i, //Cantidad de minutos,
            'sec' => $interval->s, //Cantidad de segundos,
        ];
        //Recorro cada elemento desglosado
        foreach ($fecha as $key => $item) {
            //Compruebo si tiene algun valor
            if (!empty($item)) {
                $plural = $item > 1 ? 's' : null;

                return "$item $key" . $plural;
            }
        }

        return 'now';
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function toString(\DateTime $dateTime)
    {
        return $dateTime->format('F j, Y H:i');
    }
}
