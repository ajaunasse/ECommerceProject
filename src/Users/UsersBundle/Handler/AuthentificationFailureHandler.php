<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 21/04/2016
 * Time: 19:40
 */

namespace Users\UsersBundle\Handler;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthentificationFailureHandler extends DefaultAuthenticationFailureHandler {

    /**
     * AuthenticationFailureHandler constructor.
     * @param HttpKernelInterface $httpKernel
     * @param HttpUtils $httpUtils
     * @param array $options
     * @param LoggerInterface|null $logger
     */
    public function __construct( HttpKernelInterface $httpKernel, HttpUtils $httpUtils, array $options, LoggerInterface $logger = null ) {
        parent::__construct( $httpKernel, $httpUtils, $options, $logger );
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return RedirectResponse
     */
    public function onAuthenticationFailure( Request $request, AuthenticationException $exception )
    {
        $session = $request->getSession();
        $response = parent::onAuthenticationFailure( $request, $exception );
        if($exception->getCode() == 0){
            $msgError = " Mot de passe ou nom d'utilisateur erroné ! ";
        } else {
            $msgError = " Problème dans le système d'authentification " ;
        }
        $session->getFlashBag()->add('danger', $msgError);

        return $response;
    }
}