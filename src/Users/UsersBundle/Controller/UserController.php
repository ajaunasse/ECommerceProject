<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 24/04/2016
 * Time: 16:07
 */

namespace Users\UsersBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response ;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('UsersBundle:Default:index.html.twig');
    }


    public function invoicAction(){
        $em = $this->getDoctrine()->getManager() ;
        $invoices = $em->getRepository('EcommerceBundle:Orders')->getInvoicByUser($this->getUser());
        return $this->render('UsersBundle:Public:User/invoic.html.twig', array(
            'invoices' => $invoices
        ));

    }

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

}