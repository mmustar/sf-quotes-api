<?php

declare(strict_types=1);

namespace App\Entity;

class Quote
{
    private $id;
    private $value;
    private $owner;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function own(QuoteOwner $owner): void
    {
        $this->owner = $owner;
        $owner->addQuote($this);
    }


}