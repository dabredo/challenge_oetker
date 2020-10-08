<?php

namespace App\Repository;

use App\Entity\RecordEntity;

interface RecordRepositoryInterface
{
    public function save(RecordEntity $record): void;

    public function delete(RecordEntity $record): void;

    public function search(?string $title, ?string $artist): array;

    public function getOne($id): ?RecordEntity;
}
