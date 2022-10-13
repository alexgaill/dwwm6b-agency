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
   public function filter(?string $minSize, ?string $maxSize, ?string $minRooms, ?string $maxRooms, ?string $minPrice, ?string $maxPrice, ?bool $transactionType, ?int $propertyType): array
   {
       dump($transactionType);
        $qb = $this->createQueryBuilder('p');
        
        $minSize ? $qb->andWhere("p.size >= ". $minSize): null;
        $maxSize ? $qb->andWhere("p.size <= ". $maxSize): null;
        $minRooms ? $qb->andWhere("p.rooms >= ". $minRooms): null;
        $maxRooms ? $qb->andWhere("p.rooms <= ". $maxRooms): null;
        $minPrice ? $qb->andWhere("p.price >= ". $minPrice): null;
        $maxPrice ? $qb->andWhere("p.price <= ". $maxPrice): null;
        // if (!empty($filter['transactionType'])) {
        is_bool($transactionType) ? $qb->andWhere("p.transactionType = " . intval($transactionType)): null;
        // }
        // if (!empty($filter['propertyType'])) {
        is_int($propertyType) ? $qb->andWhere("p.propertyType = ". $propertyType): null;
        // }
        dump($qb->getQuery());
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
