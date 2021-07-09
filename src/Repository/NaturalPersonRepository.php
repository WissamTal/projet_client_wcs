<?php

namespace App\Repository;

use App\Entity\NaturalPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NaturalPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method NaturalPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method NaturalPerson[]    findAll()
 * @method NaturalPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NaturalPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NaturalPerson::class);
    }

    public function findByPers(int $id)
    {
        return $this->createQueryBuilder('n')
            ->where('ns.id = :id')
            ->join('n.structureMember', 'ns')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findLikeName(string $name)
    {
        return $this->createQueryBuilder('n')
            ->where('n.lastname LIKE :name')
            ->orWhere('n.firstname LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }
}
