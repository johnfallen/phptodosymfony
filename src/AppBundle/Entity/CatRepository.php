<?php
namespace AppBundle\Entity;
/**
 * I am the Cat Repository or Gateway if you will.
 *
 * @author John Allen
 * @version 1.0
 */

use Doctrine\ORM\EntityRepository;


class CatRepository extends EntityRepository {

    /**
     * I return an array of Cats ordered by their Name
     *
     * @return array
     */
    public function findAllOrderedByName() {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM AppBundle:Cat c ORDER BY c.name ASC'
            )
            ->getResult();
    }
}