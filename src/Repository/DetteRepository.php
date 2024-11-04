<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Dette;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dette>
 */
class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

    //    /**
    //     * @return Dette[] Returns an array of Dette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Dette
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByStatut(?string $statut): array
{
    $queryBuilder = $this->createQueryBuilder('d');

    if ($statut !== null) {
        $queryBuilder->andWhere('d.statut = :statut')
                     ->setParameter('statut', $statut);
    }

    return $queryBuilder->getQuery()->getResult();
}




public function filterDette(?string $statut, ?Client $client, ?DateTimeImmutable $date): array
{
    $qb = $this->createQueryBuilder('d');

    // Filtre par statut
    if ($statut !== null) {
        $qb->andWhere('d.statut = :statut')
           ->setParameter('statut', $statut);
    }

    // Filtre par client
    if ($client !== null) {
        $qb->andWhere('d.client = :client')
           ->setParameter('client', $client);
    }

    // Filtre par date
    if ($date !== null) {
        $qb->andWhere('d.date = :date')
           ->setParameter('date', $date);
    }

    return $qb->getQuery()->getResult();
}


}
