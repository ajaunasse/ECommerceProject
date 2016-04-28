<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 28/04/2016
 * Time: 18:56
 */

namespace Ecommerce\EcommerceBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageAdminController extends Controller
{

    public function indexAction(){
        $em = $this->getDoctrine()->getManager() ;
        $pages = $em->getRepository('PagesBundle:Pages')->findAll() ;

        return $this->render('PagesBundle:Admin:index.html.twig', array(
            'pages' => $pages,
        ));
    }

}