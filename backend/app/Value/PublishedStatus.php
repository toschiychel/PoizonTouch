<?php

namespace App\Value;

class PublishedStatus
{
    public function __construct(private bool $isPublished) 
    {
    }

    public function label(): string
    {
        return $this->isPublished ? 'Опубликован' : 'Не опубликован';
    }

    public static function make(bool $value): self
    {
        return new self($value);
    }
}
