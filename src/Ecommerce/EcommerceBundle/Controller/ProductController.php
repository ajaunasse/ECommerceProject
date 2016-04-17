<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 16/04/2016
 * Time: 17:18
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Ecommerce\EcommerceBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager() ;
        $products = $em->getRepository("EcommerceBundle:Products")->findAll() ;


        return $this->render('EcommerceBundle:Public:Products/products.html.twig', array(
            'products' => $products
        ));
    }

    /**
     * Get all products according to the Category
     * @param $idCategory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction($idCategory){

        $em = $this->getDoctrine()->getManager() ;
        $products = $em->getRepository('EcommerceBundle:Products')->getAllByCategorie($idCategory) ;

        return $this->render('EcommerceBundle:Public:Products/products.html.twig',array(
            'products' => $products
        ));
    }

    public function singleAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $product = $em->getRepository('EcommerceBundle:Products')->find($id) ;

        if(!$product) throw new NotFoundHttpException("Ce produit n'existe pas !") ;

        return $this->render('EcommerceBundle:Public:Products/singleProduct.html.twig',array(
            'product' => $product
        ));
    }

    public function searchAction($value){
        $em = $this->getDoctrine()->getManager() ;
        $products = $em->getRepository('EcommerceBundle:Products')->getAllByCategorie($value) ;

        return $this->render('EcommerceBundle:Public:Products/products.html.twig',array(
            'products' => $products
        ));
    }
}