<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SubFamilyRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubFamilyRepository extends EntityRepository
{
    public function createOrderedQuery()
    {
        return $this->createQueryBuilder('sub_family')->orderBy('sub_family.name', 'ASC');
    }
}