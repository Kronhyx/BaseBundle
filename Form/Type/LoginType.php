<?php

namespace Kronhyx\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class LoginType
 * @package Kronhyx\BaseBundle\Form\Type
 */
class LoginType extends AbstractType
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
                'label' => 'kronhyx.base.label.submit',
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
