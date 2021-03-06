<?php
namespace AppBundle\Entity;
/**
 * I am the Owner Repository or Gateway if you will.
 *
 * @author John Allen
 * @version 1.0
 */
use Doctrine\ORM\EntityRepository;

class OwnerRepository extends EntityRepository {

    /**
     * I return an array of Owners ordered by their Last Name
     *
     * @return array
     */
    public function findAllOrderedByLastName() {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT o FROM AppBundle:Owner o ORDER BY o.lastName ASC'
            )
            ->getResult();
    }
}