<?php

namespace App\Repository;

use App\Entity\LegalPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LegalPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalPerson[]    findAll()
 * @method LegalPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalPerson::class);
    }


    public function findByPers(int $id)
    {
        return $this->createQueryBuilder('l')
            ->where('ls.id = :id')
            ->join('l.structure', 'ls')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findLikeName(string $name)
    {
        return $this->createQueryBuilder('l')
            ->where('ln.lastname LIKE :name')
            ->orWhere('ln.firstname LIKE :name')
            ->join('l.mainRepresentative', 'ln')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }
}
