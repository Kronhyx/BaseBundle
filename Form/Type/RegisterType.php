<?php

namespace Kronhyx\BaseBundle\Form\Type;

use Kronhyx\BaseBundle\Base\FormTypeBase;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegisterType
 * @package Kronhyx\BaseBundle\Form\Type
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class RegisterType extends FormTypeBase
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class, [
                'label' => 'kronhyx.base.label.email',
                'attr' => [
                    'placeholder' => 'kronhyx.base.placeholder.email'
                ]
            ])
            ->add('user', TextType::class, [
                'label' => 'kronhyx.base.label.username',
                'attr' => [
                    'placeholder' => 'kronhyx.base.placeholder.username'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'kronhyx.base.label.password',
                'attr' => [
                    'placeholder' => 'kronhyx.base.placeholder.password'
                ]
            ])
            ->add('terms', CheckboxType::class, [
                'label' => 'kronhyx.base.label.terms'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'kronhyx.base.label.submit'
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
