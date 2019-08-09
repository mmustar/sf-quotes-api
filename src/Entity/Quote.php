<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Quote
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
    private $value;
    /**
     * @ORM\ManyToOne(targetEntity="QuoteOwner", inversedBy="quotes")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false)
     */
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