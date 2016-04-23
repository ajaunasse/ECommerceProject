<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 23/04/2016
 * Time: 15:44
 */

namespace Ecommerce\EcommerceBundle\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Ecommerce\EcommerceBundle\Entity\Orders;


class GetReference
{

    public function __construct($securityContext, $entityManager)
    {
        $this->securityContext = $securityContext ;
        $this->em  = $entityManager ;

    }

    public function reference(){
        $reference = $this->em->getRepository('EcommerceBundle:Orders')->findOneBy(
            array('validate' => 1),
            array('id'=>'DESC'),
            1, 1);
        if(!$reference){
            return 1 ;
        } else {
            return $reference->getReference()+1 ;
        }
    }

}