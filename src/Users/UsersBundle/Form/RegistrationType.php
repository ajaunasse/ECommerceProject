<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 17/04/2016
 * Time: 16:43
 */

namespace Users\UsersBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname','text', array(
            'label' => 'form.lastname', 'translation_domain' => 'FOSUserBundle',
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('firstname','text', array(
            'label' => 'form.firstname', 'translation_domain' => 'FOSUserBundle',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}