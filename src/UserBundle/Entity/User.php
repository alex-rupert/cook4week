<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\Fridge", mappedBy="user")
     */
    private $fridges;

    public function __construct()
    {
        parent::__construct();
        
        $this->fridges = new ArrayCollection();
    }

    /**
     * Add fridge
     *
     * @param \AdminBundle\Entity\Fridge $fridge
     *
     * @return User
     */
    public function addFridge(\AdminBundle\Entity\Fridge $fridge)
    {
        $this->fridges[] = $fridge;

        return $this;
    }

    /**
     * Remove fridge
     *
     * @param \AdminBundle\Entity\Fridge $fridge
     */
    public function removeFridge(\AdminBundle\Entity\Fridge $fridge)
    {
        $this->fridges->removeElement($fridge);
    }

    /**
     * Get fridges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFridges()
    {
        return $this->fridges;
    }
}
