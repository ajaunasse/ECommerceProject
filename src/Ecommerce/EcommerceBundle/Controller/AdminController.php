<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 17/04/2016
 * Time: 11:20
 */

namespace Ecommerce\EcommerceBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    public function indexAction(){
        return $this->render('EcommerceBundle:Admin:index.html.twig');
    }
}