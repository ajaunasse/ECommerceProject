<?php

namespace Users\UsersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdressType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adress','text', array(
                'label' => 'address.address', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('complement','text', array(
                'label' => 'address.complement', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => false,
            ))
            ->add('country','text', array(
                'label' => 'address.country', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('city','text', array(
                'label' => 'address.city', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('postcode','text', array(
                'label' => 'address.postcode', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('phone','text', array(
                'label' => 'address.phone', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            //->add('user')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Users\UsersBundle\Entity\UserAdress'
        ));
    }
}
