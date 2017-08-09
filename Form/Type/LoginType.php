<?php

namespace Kronhyx\BaseBundle\Form\Type;

use Kronhyx\BaseBundle\Base\FormTypeBase;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LoginType
 * @package Kronhyx\BaseBundle\Form\Type
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class LoginType extends FormTypeBase
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('user', TextType::class, [
                'label' => 'kronhyx.base.label.username',
                'attr' => [
                    'placeholder' => 'kronhyx.base.placeholder.username'
                ]
            ])
            ->add('password', TextType::class, [
                'label' => 'kronhyx.base.label.password',
                'attr' => [
                    'placeholder' => 'kronhyx.base.placeholder.password'
                ]
            ])
            ->add('rememberme', CheckboxType::class, [
                'label' => 'kronhyx.base.label.rememberme',
            ])
            ->add('submit', ButtonType::class, [
                'label' => 'kronhyx.base.label.login',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {

    }

}
