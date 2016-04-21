<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 20/04/2016
 * Time: 20:32
 */

namespace Ecommerce\EcommerceBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Tests\ProjectServiceContainer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class RedirectionListener
{

    /**
     * RedirectionListener constructor.
     * @param ContainerInterface $container
     * @param Session $session
     */
    public function __construct(ContainerInterface $container, Session $session)
    {
        $this->session = $session ;
        $this->router = $container->get('router') ;
        $this->securityContext = $container->get('security.context') ;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event){
        $request        = $event->getRequest() ;
        $list_route     = array('_cart', '_category', '_delivery','_validate','_product','_homepage');
        $route          = $request->attributes->get('_route') ;
        $route_params   = $request->attributes->get('_route_params') ;

        if(in_array($route, $list_route)){
            $this->setRouteSession($request, $route, $route_params);
        }
        if($route == "_delivery" || $route =="_validate"){
            if ($this->session->has('cart')){
                if(count($this->session->get('cart')) == 0){
                    $this->session->getFlashBag()->add('info', 'Votre panier étant vide, vous ne pouvez pas continuer le processus d\'achat ');
                    $event->setResponse(new RedirectResponse($this->router->generate('_cart')));
                }
            }
            if(!is_object($this->securityContext->getToken()->getUser())){
                $this->session->getFlashBag()->add('info', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }

    }

    /**
     * @param $request
     * @param $route
     * @param null $param
     */
    private function setRouteSession($request, $route, $param){
        $session = $request->getSession() ;
        $session->set('lastPath', array(
            'route' => $route,
            'params' => $param
        ));
    }
}