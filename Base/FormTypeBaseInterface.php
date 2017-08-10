<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 04/08/2017
 * Time: 11:21 PM
 */

namespace Kronhyx\BaseBundle\Base;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Interface FormTypeBaseInterface
 * @package Kronhyx\BaseBundle\Base
 */
interface FormTypeBaseInterface extends EventSubscriberInterface
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options);

}