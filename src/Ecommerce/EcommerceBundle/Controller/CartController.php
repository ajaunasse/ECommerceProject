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
use Users\UsersBundle\Entity\UserAdress;
use Users\UsersBundle\Form\UserAdressType;

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

    public function menuAction(Request $request){
        $session    = $request->getSession() ;
        $em = $this->getDoctrine()->getManager() ;
        if(!$session->has('cart')){
            $cart = $session->set('cart',array()) ;
            $size = 0 ;
            $products=null;
        } else {
            $cart  = $session->get('cart') ;
            $size = count($session->get('cart')) ;
            $products = $em->getRepository('EcommerceBundle:Products')->findArray(array_keys($cart));
        }

        return $this->render('EcommerceBundle:Public:Cart/menu_cart.html.twig',array(
            'products'  => $products,
            'size'      => $size,
            'cart'      => $cart
        ));
    }

    /**
     * TODO
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deliveryAction(Request $request){
        $formType = new UserAdressType();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity = new UserAdress() ;
        $form = $this->createForm($formType,$entity) ;
        if($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if($form->isValid()){
             //   $entity = $form->getData() ;
                $em = $this->getDoctrine()->getManager() ;
                $entity->setUser($user);
                $em->persist($entity);
                $em->flush();
                $this->addFlash('success', 'Adresse ajoutée avec succès');
            } else {
                var_dump($form->getErrors());
            }
        }
        return $this->render('EcommerceBundle:Public:Cart/delivery.html.twig',array(
            'form' => $form->createView(),
            'user' => $user,
        ));
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
                $this->addFlash('success', 'Quantité modifiée avec succès');
            }
        } else {
            if($qte != null){
                $cart[$id] = $qte;
            } else {
                $cart[$id] = 1 ;
            }
            $this->addFlash('success', 'Article ajouté au panier');
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
            $this->addFlash('success', 'Article supprimé  ');
        }
        $session->set('cart', $cart) ;
        return $this->redirect($this->generateUrl('_cart')) ;
    }
}

