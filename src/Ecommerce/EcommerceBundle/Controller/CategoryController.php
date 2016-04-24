<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 17/04/2016
 * Time: 18:24
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{

    public function listAction($param){
        $em = $this->getDoctrine()->getManager()->getRepository('EcommerceBundle:Category') ;
        $categories = $em->findAll() ;
        return $this->render('EcommerceBundle:Public:category/modules/list.html.twig', array(
            'categories' => $categories,
            'param'     => $param
        )) ;
    }

}