<?php

namespace App\Repository;

use App\Entity\Executive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Executive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Executive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Executive[]    findAll()
 * @method Executive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExecutiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Executive::class);
    }

    public function findExecutive(string $name)
    {
        return $this->createQueryBuilder('e')
            ->where('e.mandateType = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
}
