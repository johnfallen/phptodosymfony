<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OwnerRepository")
 * @ORM\Table(name="cat_owner")
 */
class Owner
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $lastName;

    /**
     * @ORM\OneToMany(targetEntity="Cat", mappedBy="owner")
     */
    protected $cats;


    /**
     * I am the constructor
     */
    public function __construct()
    {
        $this->cats = new ArrayCollection();
    }


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
     * Set firstName
     *
     * @param string $firstName
     * @return Owner
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Owner
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Add cats
     *
     * @param \AppBundle\Entity\Cat $cats
     * @return Owner
     */
    public function addCat(\AppBundle\Entity\Cat $cats)
    {
        $this->cats[] = $cats;

        return $this;
    }

    /**
     * Remove cats
     *
     * @param \AppBundle\Entity\Cat $cats
     */
    public function removeCat(\AppBundle\Entity\Cat $cats)
    {
        $this->cats->removeElement($cats);
    }

    /**
     * Get cats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCats()
    {
        return $this->cats;
    }
}
