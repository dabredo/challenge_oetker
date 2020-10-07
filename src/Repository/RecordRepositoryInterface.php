<?php

namespace App\Repository;

use App\Entity\RecordEntity;

interface RecordRepositoryInterface
{
    public function save(RecordEntity $record);

    public function delete(RecordEntity $record);

    public function search(?string $title, ?string $author);
}
