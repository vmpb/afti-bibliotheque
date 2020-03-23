<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findArticleByTerm($term) {
        $term = '%'.$term.'%';
        return $this->createQueryBuilder("a")
            ->orWhere('a.title LIKE :term')
            ->orWhere('a.author LIKE :term')
            ->orderBy('a.title','ASC')
            ->setParameter(':term', $term)
            ->getQuery()
            ->getResult()
            ;
    }
}
