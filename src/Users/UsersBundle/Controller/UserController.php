<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 24/04/2016
 * Time: 16:07
 */

namespace Users\UsersBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response ;
use Users\UsersBundle\Entity\UserAdress;
use Users\UsersBundle\Form\UserAdressType;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('UsersBundle:Default:index.html.twig');
    }

    /**
     * @return Response
     */
    public function invoicAction(){
        $em = $this->getDoctrine()->getManager() ;
        $invoices = $em->getRepository('EcommerceBundle:Orders')->getInvoicByUser($this->getUser());
        return $this->render('UsersBundle:Public:User/invoic.html.twig', array(
            'invoices' => $invoices
        ));

    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function invoicPdfAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $invoic = $em->getRepository('EcommerceBundle:Orders')->findOneBy(
            array(
                'user' => $this->getUser(),
                'validate' => 1,
                'id' => $id
            ));
        if(!$invoic){
            $this->addFlash('danger', 'La facture n\'existe pas ');
            return $this->redirect($this->generateUrl('_invoic_user'));
        }

        $html = $this->renderView('UsersBundle:Public:User/invoicPDF.html.twig', array('invoic'=>$invoic));
        $html2pdf = $this->get('html2pdf_factory')->create();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->pdf->setSubject('Facture : My E-Commerce');
        $html2pdf->pdf->setTitle('Facture : n°'. $invoic->getReference());
        $html2pdf->writeHTML($html);
        $html2pdf->Output('invoic.pdf') ;

        return new Response($html2pdf->Output('invoic.pdf'), 200, array('Content-Type' => 'application/pdf'));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function invoicHtmlAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $invoic = $em->getRepository('EcommerceBundle:Orders')->findOneBy(
            array(
                'user' => $this->getUser(),
                'validate' => 1,
                'id' => $id
            ));
        if(!$invoic){
            $this->addFlash('danger', 'La facture n\'existe pas ');
            return $this->redirect($this->generateUrl('_invoic_user'));
        }
        return $this->render('UsersBundle:Public:User/invoicPDF.html.twig', array(
            'invoic' => $invoic
        ));
    }

    public function addressAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $user = $this->getUser() ;
        if($id == $user->getId()){
            $addresses = $em->getRepository('UsersBundle:UserAdress')->findBy(array('user' => $id)) ;
        } else {
            $this->addFlash('danger', 'Vous ne pouvez accedez aux adresses de cet utilisateur');
            return $this->redirect($this->generateUrl('_homepage'));
        }


        return $this->render('UsersBundle:Public:User/address.html.twig', array(
            'addresses' => $addresses
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addressAddAction(Request $request){
        $em = $this->getDoctrine()->getManager() ;
        $user = $this->getUser();
        $a = new UserAdress() ;
        $type = new UserAdressType();
        $form = $this->createForm($type,$a) ;
        if($request->isMethod("POST")){
            $form->handleRequest($request) ;
            if($form->isValid()){
                $a = $form->getData() ;
                $a->setUser($user);
                $em->persist($a) ;
                $em->flush() ;
                $this->addFlash('success' , 'Adresse ajoutée avec succès') ;
                return $this->redirect($this->generateUrl("_address_user", array('id' => $user->getId()))) ;
            } else {
                $this->addFlash('danger' , 'Problème système dans la création de l\'adresse') ;
                return $this->redirect($this->generateUrl("_address_user", array('id' => $user->getId()))) ;
            }
        }
        return $this->render('UsersBundle:Public:User/address_action.html.twig', array(
            'form'      => $form->createView(),
        ));
    }


    public function addressEditAction(Request $request,UserAdress $address){
        $em = $this->getDoctrine()->getManager() ;
        $user = $this->getUser();
        $type = new UserAdressType() ;
        $form = $this->createForm($type,$address) ;

        if($address->getUser()->getId() != $user->getId()){
            $this->addFlash('danger', 'Vous ne pouvez accedez aux adresses de cet utilisateur');
            return $this->redirect($this->generateUrl('_homepage'));
        }
        if($request->isMethod("POST")){
            $form->handleRequest($request) ;
            if($form->isValid()){
                $a = $form->getData() ;
                $a->setUser($user);
                $em->persist($a) ;
                $em->flush() ;
                $this->addFlash('success' , 'Adresse modifiée avec succès') ;
                return $this->redirect($this->generateUrl("_address_user", array('id' => $user->getId()))) ;
            } else {
                $this->addFlash('danger' , 'Problème système dans la modification de l\'adresse') ;
                return $this->redirect($this->generateUrl("_address_user", array('id' => $user->getId()))) ;
            }

        }
        return $this->render('UsersBundle:Public:User/edit_address.html.twig', array(
            'id'        => $address->getId(),
            'form'      => $form->createView(),
        ));
    }

    public function addressDelAction(UserAdress $address){
        $em = $this->getDoctrine()->getManager() ;
        $user = $this->getUser();
        if($user->getId() != $address->getUser()->getId()){
            $this->addFlash('danger', 'Vous ne pouvez accedez aux adresses de cet utilisateur');
            return $this->redirect($this->generateUrl('_homepage'));
        }
        $em->remove($address) ;
        $em->flush() ;
        $this->addFlash('success', 'Adresse supprimée avec succès') ;
        return $this->redirect($this->generateUrl("_address_user", array('id' => $user->getId()))) ;
    }

}