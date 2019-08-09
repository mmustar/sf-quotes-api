<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  @ORM\Entity
 *  @UniqueEntity("value",message="Quote already present in database")
 */
class Quote
{
    /**
     * @Groups({"quote"})
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @Groups({"quote"})
     * @ORM\Column(type="string", length=150, unique=true)
     * @Assert\NotBlank(message="Quote cannot be blank")
     * @Assert\Length(max="150", maxMessage="Quote must be less than 150 caracters")
     */
    private $value;
    /**
     * @Groups({"quote"})
     * @ORM\ManyToOne(targetEntity="QuoteOwner", inversedBy="quotes")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="Owner cannot be null")
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

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getOwner()
    {
        return $this->owner;
    }




}