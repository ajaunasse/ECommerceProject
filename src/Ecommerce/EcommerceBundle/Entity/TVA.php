<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TVA
 *
 * @ORM\Table(name="tva")
 * @ORM\Entity(repositoryClass="Ecommerce\EcommerceBundle\Repository\TVARepository")
 */
class TVA
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="multiplicate", type="float")
     */
    private $multiplicate;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set multiplicate
     *
     * @param float $multiplicate
     * @return TVA
     */
    public function setMultiplicate($multiplicate)
    {
        $this->multiplicate = $multiplicate;

        return $this;
    }

    /**
     * Get multiplicate
     *
     * @return float 
     */
    public function getMultiplicate()
    {
        return $this->multiplicate;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return TVA
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return TVA
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }
}
