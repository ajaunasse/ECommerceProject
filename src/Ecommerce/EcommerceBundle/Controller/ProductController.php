<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 16/04/2016
 * Time: 17:18
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Ecommerce\EcommerceBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ecommerce\EcommerceBundle\Entity\Category;

class ProductController extends Controller
{

    /**
     * @param Request $request
     * @param Category|null $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request,Category $category = null){

        $em = $this->getDoctrine()->getManager() ;
        $session =  $request->getSession() ;
        if($category != null){
            $findproducts = $em->getRepository('EcommerceBundle:Products')->getAllByCategorie($category->getId()) ;
        } else {
            $findproducts = $em->getRepository("EcommerceBundle:Products")->findBy(array('available'=>1)) ;
        }
        if($session->has('cart')){
            $cart = $session->get('cart') ;
        } else {
            $cart = false ;
        }
        //Pagination
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $findproducts,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('EcommerceBundle:Public:Products/products.html.twig', array(
            'products' => $products,
            'cart'      => $cart,
        ));
    }

    public function singleAction(Request $request ,$id){
        $em = $this->getDoctrine()->getManager() ;
        $product = $em->getRepository('EcommerceBundle:Products')->find($id) ;
        $session =  $request->getSession() ;
        if($session->has('cart')){
            $cart = $session->get('cart') ;
        } else {
            $cart = false ;
        }
        if(!$product) throw new NotFoundHttpException("Ce produit n'existe pas !") ;

        return $this->render('EcommerceBundle:Public:Products/singleProduct.html.twig',array(
            'product' => $product,
            'cart'    => $cart,
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formSearchAction(){
        $form = $this->createForm(new SearchType());
        return $this->render('EcommerceBundle:Public:Search/search.html.twig',array(
            'form' => $form->createView()
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request){
        $form = $this->createForm(new SearchType());
        $products = null ;
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            $value = ($form['search']->getData());
            $em = $this->getDoctrine()->getManager() ;
            $products = $em->getRepository('EcommerceBundle:Products')->search($value) ;
        }
        if(!$products){
            $this->addFlash('danger', 'Acun article trouvé correspondant à la recherche : '.$value);
        }


        return $this->render('EcommerceBundle:Public:Products/products.html.twig',array(
            'products' => $products
        ));
    }
}