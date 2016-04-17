<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 17/04/2016
 * Time: 17:50
 */

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\Media ;

class LoadMediaData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $media = new Media() ;
        $media->setAlt("MonImage") ;
        $media->setPath("MonImage.png") ;

        $manager->persist($media) ;
        $manager->flush() ;
    }

}