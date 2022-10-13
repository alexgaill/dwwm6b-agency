<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function save(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @param array $filter Ensemble des filtres de recherche de propriétés
    * @return Property[] Returns an array of Property objects
    */
   public function filter(array $filter): array
   {
        $qb = $this->createQueryBuilder('p');
        
        $filter['minSize'] ? $qb->andWhere("p.size >= ". $filter['minSize']): null;
        $filter['maxSize'] ? $qb->andWhere("p.size <= ". $filter['maxSize']): null;
        $filter['minRooms'] ? $qb->andWhere("p.rooms >= ". $filter['minRooms']): null;
        $filter['maxRooms'] ? $qb->andWhere("p.rooms <= ". $filter['maxRooms']): null;
        $filter['minPrice'] ? $qb->andWhere("p.price >= ". $filter['minPrice']): null;
        $filter['maxPrice'] ? $qb->andWhere("p.price <= ". $filter['maxPrice']): null;
        $filter['transactionType'] ? $qb->andWhere("p.transactionType = " . $filter['transactionType']): null;
        $filter['propertyType'] ? $qb->andWhere("p.propertyType = " . $filter['propertyType']): null;
        
        return $qb->getQuery()
        ->getResult();
   }

//    public function findOneBySomeField($value): ?Property
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
