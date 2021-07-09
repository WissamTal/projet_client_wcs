<?php

namespace App\Repository;

use App\Entity\Associate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Associate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Associate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Associate[]    findAll()
 * @method Associate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssociateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Associate::class);
    }

    public function findAncienAssociate()
    {
        return $this->createQueryBuilder('a')
            ->where('a.numberOfShare = 0')
            ->getQuery()
            ->getResult();
    }

    public function findAssociate()
    {
        return $this->createQueryBuilder('a')
            ->where('a.numberOfShare > 0')
            ->getQuery()
            ->getResult();
    }
}
