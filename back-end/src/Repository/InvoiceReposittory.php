<?php
namespace App\Repository;
use App\Entity\Invoice;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
class InvoiceRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, Invoice::class);
    }
    public function findByClientId(int $clientId): ?Invoice
    {
        return $this->createQueryBuilder('invoice')
            ->andwhere('invoice.clientId = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
