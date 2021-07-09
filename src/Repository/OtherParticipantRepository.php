<?php

namespace App\Repository;

use App\Entity\OtherParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OtherParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtherParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtherParticipant[]    findAll()
 * @method OtherParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtherParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OtherParticipant::class);
    }

    public function findOther(string $name)
    {
        return $this->createQueryBuilder('o')
            ->where('o.otherParticipantRole = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
}
