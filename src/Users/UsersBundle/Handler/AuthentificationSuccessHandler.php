<?php

namespace Users\UsersBundle\Handler;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class AuthentificationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    /**
     * AfterLoginRedirection constructor.
     * @param Router $router
     * @param AuthorizationChecker $security
     */
    public function __construct(Router $router, AuthorizationChecker $security)
    {
        $this->router = $router;
        $this->security = $security;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        var_dump($request->server->get('HTTP_REFERER'));
        die();
        $session = $request->getSession();
        if(!$session->has('lastPath')){
            $route = '_homepage';
        } else {
            $route = $session->get('lastPath') ;
        }

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('_homepage_admin'));
        } else {
            if($route['params'] != null){
                $response = new RedirectResponse($this->router->generate($route['route'],$route['params']));
            } else {
                $response = new RedirectResponse($this->router->generate($route['route']));
            }

        }
        $session->getFlashBag()->add('success', 'Connexion réussi !');
        return $response;
    }

}