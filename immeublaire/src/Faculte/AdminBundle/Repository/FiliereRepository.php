<?php

namespace Faculte\AdminBundle\Repository;

/**
 * FiliereRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FiliereRepository extends \Doctrine\ORM\EntityRepository
{
    public function findWithoutId($idF){
        $query = $this->createQueryBuilder('filiere')
            ->select('filiere')
            ->where('filiere.id != :idF')
            ->setParameters(array('idF'=>$idF))
            ->getQuery()
            ->getResult();
        return $query;
    }
}