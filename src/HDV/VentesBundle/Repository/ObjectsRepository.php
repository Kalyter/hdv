<?php

namespace HDV\VentesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ObjectsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObjectsRepository extends \Doctrine\ORM\EntityRepository
{

  public function getLastResults()
   {
     $qb = $this->createQueryBuilder('o')
       ->where('o.adjuge > :prix')
       ->setParameter('prix', '1200')
       ->orderBy('o.adjuge', 'DESC')
     ;

     return $qb
       ->getQuery()
       ->getResult()
     ;
   }

}