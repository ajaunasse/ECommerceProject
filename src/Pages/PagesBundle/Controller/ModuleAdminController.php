<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 28/04/2016
 * Time: 22:13
 */

namespace Pages\PagesBundle\Controller;


use Pages\PagesBundle\Entity\Modules;
use Pages\PagesBundle\Form\ModulesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ModuleAdminController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager() ;
        $modules = $em->getRepository('PagesBundle:Modules')->findAll() ;

        return $this->render('PagesBundle:Admin:Modules/index.html.twig', array(
            'modules' => $modules,
        )) ;

    }

    public function addAction(Request $request){
        $m = new Modules();
        $type = new ModulesType() ;
        $form = $this->createForm($type,$m) ;
        if($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if($form->isValid()){
                $m = $form->getData() ;
                $em = $this->getDoctrine()->getManager() ;
                $em->persist($m);

                $em->flush();
                $id = $m->getId();
                $this->addFlash('success', 'Module ajoutée avec succès');
                var_dump($id);
                return $this->redirect($this->generateUrl('_admin_page', array('id' => $id))) ;
            }
        }

        return $this->render('PagesBundle:Admin:Modules/add_module.html.twig',array(
            'form' => $form->createView(),
        ));
    }

}