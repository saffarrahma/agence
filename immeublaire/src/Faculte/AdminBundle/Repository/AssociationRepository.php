<?php

namespace Faculte\AdminBundle\Repository;

/**
 * AssociationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AssociationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findWithoutId($idA){
        $query = $this->createQueryBuilder('association')
            ->select('association')
            ->where('association.id != :idA')
            ->setParameters(array('idA'=>$idA))
            ->getQuery()
            ->getResult();
        return $query;
    }
}
