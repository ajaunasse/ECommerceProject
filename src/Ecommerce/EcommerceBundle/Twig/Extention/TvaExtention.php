<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 17/04/2016
 * Time: 22:30
 */

namespace Ecommerce\EcommerceBundle\Twig\Extention;


class TvaExtention extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters(){
        return array(new \Twig_SimpleFilter('tva', array($this,'calculateTva'))) ;
    }

    /**
     * @param $priceHT
     * @param $multiTva
     * @return mixed
     */
    public function calculateTva($priceHT, $multiTva){
        return round($priceHT * $multiTva,2) ;
    }
    /**
     *
     */
    public function getName()
    {
        return 'tva_extension' ;
    }


}