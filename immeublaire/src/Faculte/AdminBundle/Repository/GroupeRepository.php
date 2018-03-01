<?php

namespace Faculte\AdminBundle\Repository;

/**
 * GroupeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findWithoutId($idG){
        $query = $this->createQueryBuilder('groupe')
            ->select('groupe')
            ->where('groupe.id != :idG')
            ->setParameters(array('idG'=>$idG))
            ->getQuery()
            ->getResult();
        return $query;
    }
}
