<?php

namespace Kronhyx\BaseBundle\Form\Type;

use Kronhyx\BaseBundle\Base\FormTypeBase;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SearchType
 * @package Kronhyx\BaseBundle\Form\Type
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class SearchType extends FormTypeBase
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', TextType::class, [
                'label' => 'kronhyx.base.search.label',
                'attr' => [
                    'placeholder' => 'kronhyx.base.placeholder.search'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }

}
