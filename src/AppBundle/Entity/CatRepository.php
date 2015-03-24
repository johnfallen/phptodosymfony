<?php
namespace AppBundle\Entity;

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