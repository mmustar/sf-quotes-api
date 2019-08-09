<?php

declare(strict_types=1);

namespace App\Entity;
use App\Entity\Quote;


class QuoteOwner
{
    private $id;
    private $fullname;
    private $quotes = [];

    public function __toString(): string
    {
        return $this->fullname;
    }

    public function __construct(string $fullname)
    {
        $this->fullname = $fullname;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Quote[]
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): void
    {
        $this->quotes[] = $quote;
    }





}