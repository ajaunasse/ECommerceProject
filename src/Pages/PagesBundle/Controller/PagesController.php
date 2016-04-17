<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function pagesAction($id)
    {
        $em = $this->getDoctrine()->getManager() ;
        $page = $em->getRepository('PagesBundle:Pages')->find($id) ;

        if(!$page) throw $this->createNotFoundException("La page demandée n'existe pas ! ") ;
        return $this->render('PagesBundle:Public:pages.html.twig', array(
            'page' => $page
        ));
    }

    public function menuAction(){
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PagesBundle:Pages')->findAll();

        return $this->render('PagesBundle:Public:modules/menu.html.twig', array(
            'pages' => $pages
        )) ;
    }
}
