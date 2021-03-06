<?php

namespace HDV\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

  public function getmyObjets($dossier)
  {
    $query = $this->createQueryBuilder('o')
      ->where('o.codedossier = :code')
      ->setParameter('code', $dossier)
      ->leftJoin('o.codevac', 'v')
      ->addSelect('v')
      //->orderBy('a.date', 'DESC')
      ->getQuery()
    ;
  }

}
