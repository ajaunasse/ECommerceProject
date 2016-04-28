<?php

namespace Pages\PagesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('content','textarea',array(
                'attr'=> array(
                    'class' => 'form-control'
                )
            ))
            ->add('online', 'checkbox')
            ->add('module', 'entity',        array(
                'class'    => 'PagesBundle:Modules',
                'property' => 'name',
                'multiple' => false,
                'attr' => array('class'=> 'form-control')
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pages\PagesBundle\Entity\Pages'
        ));
    }
}
