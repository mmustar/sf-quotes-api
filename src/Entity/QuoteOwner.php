<?php

declare(strict_types=1);

namespace App\Entity;
use App\Entity\Quote;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class QuoteOwner
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", length="150")
     */
    private $fullname;
    /**
     * @ORM\OneToMany(targetEntity="Quote", "mappedBy="owner")
     */
    private $quotes;

    public function __toString(): string
    {
        return $this->fullname;
    }

    public function __construct(string $fullname)
    {
        $this->fullname = $fullname;
        $this->quotes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuotes(): ArrayCollection
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): void
    {
        $this->quotes->add($quote);
    }




}