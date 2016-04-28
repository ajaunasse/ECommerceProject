<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 28/04/2016
 * Time: 18:56
 */

namespace Pages\PagesBundle\Controller;



use Pages\PagesBundle\Entity\Pages;
use Pages\PagesBundle\Form\PagesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageAdminController extends Controller
{

    public function indexAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $pages = $em->getRepository('PagesBundle:Pages')->findBy(array('module'=> $id   )) ;

        return $this->render('PagesBundle:Admin:Pages/index.html.twig', array(
            'pages' => $pages,
        ));
    }

    public function addAction(Request $request){
        $p = new Pages();
        $type = new PagesType() ;
        $form = $this->createForm($type,$p) ;
        if($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if($form->isValid()){
                $p = $form->getData() ;
                $em = $this->getDoctrine()->getManager() ;
                $em->persist($p);
                $em->flush();
                $id = $p->getId() ;
                $this->addFlash('success', 'Adresse ajoutée avec succès');
            }
        }

        return $this->render('PagesBundle:Admin:Pages/add_pages.html.twig',array(
            'form' => $form->createView(),
        ));
    }

}