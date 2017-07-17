<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 12/06/2016
 * Time: 1:24 PM.
 */

namespace Kronhyx\BaseBundle\Twig\_Extension;

/**
 * Class TimerExtension
 * @package Kronhyx\BaseBundle\Twig\_Extension
 * @author Randy Téllez <kronhyx@gmail.com>
 */
class TimerExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('time', [
                $this, 'timeFilter',
            ]),
        );
    }

    /**
     * @param \DateTime|null $after
     * @param \DateTime|null $before
     * @return string
     */
    public function timeFilter(\DateTime $after = null, \DateTime $before = null)
    {
        //Compruebo que exista una fecha antigua
        $after = $after ?? new \DateTime();
        $before = $before ?? new \DateTime();

        //Obtengo el intervalo entre la fecha del numero y la fecha actual
        $interval = $after->diff($before);

        //Obtengo el intervalo desglosado
        $fecha = [
            'anno' => $interval->y, //Cantidad de annos,
            'mese' => $interval->m, //Cantidad de meses,
            'dia' => $interval->d, //Cantidad de dias,
            'hora' => $interval->h, //Cantidad de horas,
            'minuto' => $interval->i, //Cantidad de minutos,
            'segundo' => $interval->s, //Cantidad de segundos,
        ];
        //Recorro cada elemento desglosado
        foreach ($fecha as $key => $item) {
            //Compruebo si tiene algun valor
            if (!empty($item)) {
                $plural = $item > 1 ? 's' : null;

                return "$item $key" . $plural;
            }
        }

        return 'ahora';
    }
}
