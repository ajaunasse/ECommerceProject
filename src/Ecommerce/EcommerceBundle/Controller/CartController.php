<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 16/04/2016
 * Time: 17:18
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller
{
    public function indexAction(){
        return $this->render('EcommerceBundle:Public:Cart/cart.html.twig');
    }

    public function deliveryAction(){
        return $this->render('EcommerceBundle:Public:Cart/delivery.html.twig');
    }

    public function validateAction(){
        return $this->render('EcommerceBundle:Public:Cart/validate.html.twig');
    }
}