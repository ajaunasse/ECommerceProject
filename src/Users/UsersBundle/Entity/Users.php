<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Jaunasse
 * Date: 16/04/2016
 * Time: 19:22
 */

namespace Users\UsersBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection ;
/**
 * @ORM\Entity(repositoryClass="Users\UsersBundle\Repository\UsersRepository")
 * @ORM\Table(name="users")
 */
class Users extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\OneToMany(targetEntity="Ecommerce\EcommerceBundle\Entity\Orders", mappedBy="user" , cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $orders ;

    /**
     * @ORM\OneToMany(targetEntity="Users\UsersBundle\Entity\UserAdress", mappedBy="user" , cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adress ;

    public function __construct()
    {
        parent::__construct();
        $this->orders = new ArrayCollection() ;
        $this->adress = new ArrayCollection() ;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }



    /**
     * Add orders
     *
     * @param \Ecommerce\EcommerceBundle\Entity\Orders $orders
     * @return Users
     */
    public function addOrder(\Ecommerce\EcommerceBundle\Entity\Orders $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \Ecommerce\EcommerceBundle\Entity\Orders $orders
     */
    public function removeOrder(\Ecommerce\EcommerceBundle\Entity\Orders $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add adress
     *
     * @param \Users\UsersBundle\Entity\UserAdress $adress
     * @return Users
     */
    public function addAdress(\Users\UsersBundle\Entity\UserAdress $adress)
    {
        $this->adress[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \Users\UsersBundle\Entity\UserAdress $adress
     */
    public function removeAdress(\Users\UsersBundle\Entity\UserAdress $adress)
    {
        $this->adress->removeElement($adress);
    }

    /**
     * Get adress
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdress()
    {
        return $this->adress;
    }
}
