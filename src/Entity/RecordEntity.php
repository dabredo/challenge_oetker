<?php

namespace App\Entity;

class RecordEntity
{
    private int $id;
    private string $title;
    private string $author;
    private string $style;
    private \DateTime $releaseDate;
    private float $price;
    private string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getStyle(): string
    {
        return $this->style;
    }

    public function getReleaseDate(): \DateTime
    {
        return $this->releaseDate;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
