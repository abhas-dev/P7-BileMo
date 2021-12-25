<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

//    public function findByKeyword(string $q, int $offset = 0, int $limit = 20): Page
//    {
//        $query = $this->createQueryBuilder("p")
//            ->andWhere("p.title like :q or p.content like :q")
//            ->setParameter('q', "%" . $q . "%")
//            ->orderBy('p.createdAt', 'DESC')
//            ->setMaxResults($limit)
//            ->setFirstResult($offset)
//            ->getQuery();
//
//        $paginator = new Paginator($query, $fetchJoinCollection = false);
//        $totalElements = count($paginator);
//        $content = new ArrayCollection();
//        foreach ($paginator as $post) {
//            $content->add(PostSummaryDto::of($post->getId(), $post->getTitle()));
//        }
//        return Page::of ($content, $totalElements, $offset, $limit);
//    }


    // /**
    //  * @return Customer[] Returns an array of Customer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Customer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
