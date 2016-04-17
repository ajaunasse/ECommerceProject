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

class ProductController extends Controller
{
    public function indexAction(){
//        $em = $this->getDoctrine()->getManager() ;
//
//        $products = $em->getRepository("EcommerceBundle:Products")->findAll() ;


        return $this->render('EcommerceBundle:Public:Products/products.html.twig');
    }

    public function singleAction($id){
//        $em = $this->getDoctrine()->getManager() ;
//
//        $product = $em->getRepository("EcommerceBundle:Products")->find($id) ;
        return $this->render('EcommerceBundle:Public:Products/singleProduct.html.twig');
    }


    public function addAction(){

//        $em = $this->getDoctrine()->getManager() ;
//        $product = new Products() ;
//        $product->setName("My Product") ;
//        $product->setDescription("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam debitis ea facilis illo inventore iusto modi molestiae nisi obcaecati sequi! Atque est facere perferendis provident reprehenderit sint tempora totam voluptates?");
//        $product->setPrice(50.00);
//        $product->setAvailable(true) ;
//        $product->setImage("monImage.png") ;
//        $product->setTVA("1.35") ;
//        $product->setCategory("Laptop");
//
//        $em->persist($product) ;
//        $em->flush() ;
//        var_dump($product);
//        die() ;


    }

}