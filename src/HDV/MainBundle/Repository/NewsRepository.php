<?php

namespace HDV\MainBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends \Doctrine\ORM\EntityRepository
{

   public function getNewsacc()
    {
      $qb = $this->createQueryBuilder('n')
        ->where('n.published = 1')
        ->orderBy('n.date', 'DESC')
        ->setMaxResults(5)
      ;

      return $qb
        ->getQuery()
        ->getResult()
      ;
    }

    public function getNews($page, $nbPerPage)
    {
      $query = $this->createQueryBuilder('n')
        ->orderBy('n.date', 'DESC')
        ->getQuery()
      ;

      $query
        // On définit l'annonce à partir de laquelle commencer la liste
        ->setFirstResult(($page-1) * $nbPerPage)
        // Ainsi que le nombre d'annonce à afficher sur une page
        ->setMaxResults($nbPerPage)
      ;

      // Enfin, on retourne l'objet Paginator correspondant à la requête construite
      // (n'oubliez pas le use correspondant en début de fichier)
      return new Paginator($query, true);
    }

}
