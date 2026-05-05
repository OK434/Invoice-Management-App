<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findByClientName(string $clientName): ?Client
    {
        return $this->createQueryBuilder('client')
            ->andWhere('client.clientName = :clientName')
            ->setParameter('clientName', $clientName)
            ->getQuery()
            ->getOneOrNullResult();


    }
    public function findByEmail(string $email): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
