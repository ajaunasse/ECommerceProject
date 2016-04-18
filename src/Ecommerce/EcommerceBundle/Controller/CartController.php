<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 16/04/2016
 * Time: 17:18
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse ;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * Return the cart of customer storage in session
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        //variables
        $session    = $request->getSession() ;

        if(!$session->has('cart')){
            $session->set('cart', array()) ;

        }
        $cart = $session->get('cart') ;
        $em=$this->getDoctrine()->getManager() ;
        $products = $em->getRepository('EcommerceBundle:Products')->findArray(array_keys($cart));

        return $this->render('EcommerceBundle:Public:Cart/cart.html.twig',array(
            'products' => $products,
            'cart'     => $cart,
        ));
    }

    /**
     * TODO
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deliveryAction(){
        return $this->render('EcommerceBundle:Public:Cart/delivery.html.twig');
    }

    /**
     * TODO
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validateAction(){
        return $this->render('EcommerceBundle:Public:Cart/validate.html.twig');
    }

    /**
     * Add a product in the cart according to the quantity
     * If the quantity is not specified, the quantity is 1.
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function addAction($id, Request $request){

        $session =  $request->getSession() ;
        $qte = $request->query->get('qte');
//        $session->remove('cart') ;
        if(!$session->has('cart')){
            $session->set('cart', array()) ;
        }

        $cart = $session->get('cart') ;
        if(array_key_exists($id,$cart)){
            if($qte !=null){
                var_dump("quantite not null, on remplace") ;
                $cart[$id] = $qte;
            } else {
                $cart[$id] = 1+$cart[$id];
            }
        } else {
            if($qte != null){
                $cart[$id] = $qte;
            } else {
                $cart[$id] = 1 ;
            }
        }
        $session->set('cart', $cart) ;
        return $this->redirect($this->generateUrl('_cart')) ;
    }

    /**
     * Delete a product of the cart
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function delAction(Request $request, $id){
        $session =  $request->getSession() ;
        $cart = $session->get('cart') ;

        if(array_key_exists($id,$cart)){
            unset($cart[$id]);
            $this->addFlash('danger', 'Article supprimé : ');
        }
        $session->set('cart', $cart) ;
        return $this->redirect($this->generateUrl('_cart')) ;
    }
}

