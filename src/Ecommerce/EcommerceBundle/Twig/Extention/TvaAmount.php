<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 17/04/2016
 * Time: 22:30
 */

namespace Ecommerce\EcommerceBundle\Twig\Extention;


class TvaAmount extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters(){
        return array(new \Twig_SimpleFilter('amountTva', array($this,'amountTva'))) ;
    }

    /**
     * @param $priceHT
     * @param $multiTva
     * @return mixed
     */
    public function amountTva($priceHT, $multiTva){
        return round(($priceHT * $multiTva) - $priceHT,2) ;
    }
    /**
     *
     */
    public function getName()
    {
        return 'amoutTva_extension' ;
    }


}