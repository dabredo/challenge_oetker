<?php

namespace App\Repository;

use App\Entity\RecordEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecordEntity::class);
    }

    public function create(RecordEntity $record): void
    {
        $this->_em->persist($record);
        $this->_em->flush();
    }
}
