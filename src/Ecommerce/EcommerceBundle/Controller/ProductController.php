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

class ProductController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager() ;
        $products = $em->getRepository("EcommerceBundle:Products")->findBy(array('available'=>1)) ;


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

        if(!$products) throw new NotFoundHttpException("La catégorie n'existe pas") ;

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