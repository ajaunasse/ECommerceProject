<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 23/04/2016
 * Time: 11:15
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Ecommerce\EcommerceBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Users\UsersBundle\Entity\UserAdress;
use Ecommerce\EcommerceBundle\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use Ecommerce\EcommerceBundle\Services\GetReference;

class OrdersController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function orderAction(Request $request){

        $session = $request->getSession() ;
        $em = $this->getDoctrine()->getManager() ;
        if(!$session->has('order')){
            $order = new Orders();
        } else {
            $order = $em->getRepository('EcommerceBundle:Orders')->find($session->get('order')) ;
        }
        $order->setDate(new \DateTime());
        $order->setUser($this->container->get('security.context')->getToken()->getUser());
        $order->setValidate(0);
        $order->setReference(0);
        $order->setOrder($this->order($request));
        if(!$session->has('order')){
            $em->persist($order);
            $session->set('order',$order) ;
        }
        $em->flush() ;

        return new Response($order->getId());
    }


    /**
     * @param Request $request
     * @param $id
     * @param $token
     * @return Response
     */
    public function paymentAction(Request $request, $id, $token){
        $em = $this->getDoctrine()->getManager() ;
        $order = $em->getRepository('EcommerceBundle:Orders')->find($id) ;
        $session = $request->getSession();

        if(!$order || $order->getValidate() != 0){
            throw $this->createNotFoundException("La commande n'existe pas ou a déjà été validée ! ") ;
        } else {
            $order->setValidate(1) ;
            $order->setReference($this->container->get('setNewRef')->reference()) ;
            $em->flush();
            $session->remove('order');
            $session->remove('adress');
            $session->remove('cart') ;

            $this->addFlash('success', "Commande validée avec succès ! Vous pouvez voir l'avancement dans votre compte") ;

            return $this->render('EcommerceBundle:Public:Orders/invoic.html.twig');
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function order(Request $request){
        // --------------------------------------------------------------
        //                          VARIABLES
        // ---------------------------------------------------------------
        $em = $this->getDoctrine()->getManager() ;
        $session = $request->getSession();
        $generator = $this->container->get('security.secure_random');
        $adress = $session->get('adress');
        $cart = $session->get('cart');
        $order = array() ;
        $amountHT = 0 ;
        $amountTTC = 0 ;
        $invoic = $em->getRepository('UsersBundle:UserAdress')->find($adress['invoicAdress']);
        $delivery = $em->getRepository('UsersBundle:UserAdress')->find($adress['deliveryAdress']);
        $products = $em->getRepository('EcommerceBundle:Products')->findArray(array_keys($cart));

        foreach($products as $product){
            //Calcul des prix
            $priceHT = ($product->getPrice() * $cart[$product->getId()]);
            $priceTTC = ($product->getPrice() * $cart[$product->getId()]) * $product->getTva()->getMultiplicate() ;
            $amountHT += $priceHT ;
            $amountTTC += $priceTTC ;

            //Calcul des TVA
            if(!isset($order['tva'][$product->getTva()->getValue().'%'])){
                $order['tva'][$product->getTva()->getValue().'%'] = round(($priceTTC - $priceHT),2);
            } else {
                $order['tva'][$product->getTva()->getValue().'%'] += round(($priceTTC - $priceHT),2);
            }

            //Products
            $order['products'][$product->getId()] = array(
                'reference' =>$product->getReference(),
                'name'      => $product->getName(),
                'quantity' => $cart[$product->getId()],
                'priceHT' => round(($product->getPrice()),2),
                'priceTTC' => round(($product->getPrice() * $product->getTva()->getMultiplicate()),2),
            ) ;
        } // End ForEach
        //delivery
        $order['delivery'] = array(
            'firstname' =>  $delivery->getUser()->getFirstName(),
            'lastname' =>  $delivery->getUser()->getLastName(),
            'email' =>  $delivery->getUser()->getEmail(),
            'phone' =>  $delivery->getPhone(),
            'adress' => $delivery->getAdress(),
            'complement' => $delivery->getComplement(),
            'city'  => $delivery->getCity(),
            'country' => $delivery->getCountry(),
            'postalcode' => $delivery->getPostcode()
        );
        //invoic
        $order['invoic'] = array(
            'firstname' =>  $invoic->getUser()->getFirstName(),
            'lastname' =>  $invoic->getUser()->getLastName(),
            'email' =>  $invoic->getUser()->getEmail(),
            'phone' =>  $invoic->getPhone(),
            'adress' => $invoic->getAdress(),
            'complement' => $invoic->getComplement(),
            'city'  => $invoic->getCity(),
            'country' => $invoic->getCountry(),
            'postalcode' => $invoic->getPostcode()
        );
        //Amount
        $order['amountHT']  = round($amountHT,2);
        $order['amountTTC'] = round($amountTTC,2);

        //Token
        $order['token'] = bin2hex($generator->nextBytes(20)) ;
        return $order ;
    }

}