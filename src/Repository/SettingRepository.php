<?php

namespace App\Repository;

use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Setting>
 */
class SettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    //    /**
    //     * @return Setting[] Returns an array of Setting objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findAboutText(): array
    {
        $results =  $this->createQueryBuilder('s')
            ->andWhere('s.type = :type')
            ->setParameter('type', 'about')
            ->andWhere('s.label LIKE :label')
            ->setParameter('label', 'text_%')
            ->orderBy('LENGTH(s.label)', 'ASC')
            ->addOrderBy('s.label', 'ASC')
            ->getQuery()
            ->getResult()
            ;

        // Reindex starting at 1
        $indexed = [];
        $i = 1;
        foreach ($results as $r) {
            $indexed[$i++] = $r;
        }

        return $indexed;
    }

}
