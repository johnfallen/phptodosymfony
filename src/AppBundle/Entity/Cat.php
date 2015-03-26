<?php
namespace AppBundle\Entity;
/**
 * I  model a Cat.
 *
 * @author John Allen
 * @version 1.0
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CatRepository")
 * @ORM\Table(name="cat")
 */
class Cat {
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Owner", inversedBy="cats")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;


    /**
     * I validate myself and return an array of errors.
     *
     * @return array
     */
    public function validate(){

        $errors = array();

        if ( strlen( $this->getName() ) == 0 ){
            $errors['name'] = 'The name must be longer than 0.';
        }

        if ( strlen( $this->getDescription() ) == 0 ){
            $errors['description'] = 'The description must be longer than 0.';
        }

        if ( $this->getOwner() == null ){
            $errors['owner'] = 'The cat must have an owner.';
        }

        return $errors;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Cat
     */
    public function setName($name){
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Cat
     */
    public function setDescription( $description ){
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * Set owner
     *
     * @param \AppBundle\Entity\Owner $owner
     * @return Cat
     */
    public function setOwner(\AppBundle\Entity\Owner $owner = null){
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\Owner
     */
    public function getOwner(){
       return $this->owner;
    }
}
