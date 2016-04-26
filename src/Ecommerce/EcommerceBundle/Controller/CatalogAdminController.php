<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 26/04/2016
 * Time: 19:46
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CatalogAdminController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EcommerceBundle:Category')->findAll();

        return $this->render('EcommerceBundle:Admin:Catalog/index.html.twig',array(
            'categories' => $categories,
        )) ;
    }

}