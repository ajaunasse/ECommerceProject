<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 17/04/2016
 * Time: 20:52
 */

namespace Ecommerce\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search','text', array(
            'label' => false,
            'attr' => array(
                'placeholder' => 'Search..',
                'class' => 'form-control',
            )
        )) ;
    }

    public function getName()
    {
        return 'ecommerce_ecommercebundle_search' ;
    }
}