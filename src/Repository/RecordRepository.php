<?php

namespace App\Repository;

use App\Entity\RecordEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RecordRepository extends ServiceEntityRepository implements RecordRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecordEntity::class);
    }

    public function save(RecordEntity $record): void
    {
        $this->_em->persist($record);
        $this->_em->flush();
    }

    public function delete(RecordEntity $record): void
    {
        $this->_em->remove($record);
        $this->_em->flush();
    }

    public function search(?string $title, ?string $artist): array
    {
        $searchBy = [];
        if (!empty($title)) {
            $searchBy['title'] = $title;
        }
        if (!empty($artist)) {
            $searchBy['artist'] = $artist;
        }

        $orderBy = [
            'artist' => 'ASC',
            'title' => 'ASC',
        ];

        return $this->findBy($searchBy, $orderBy);
    }

    public function getOne($id): ?RecordEntity
    {
        return $this->find($id);
    }
}
