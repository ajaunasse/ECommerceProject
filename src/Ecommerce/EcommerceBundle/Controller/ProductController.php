<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 16/04/2016
 * Time: 17:18
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction(){
        return $this->render('EcommerceBundle:Public:Products/products.html.twig');
    }

    public function singleAction(){
        return $this->render('EcommerceBundle:Public:Products/singleProduct.html.twig');
    }


}