<?php

declare(strict_types=1);

namespace App\Entity;
use App\Entity\Quote;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity("fullname",message="Author already present in database")
 */

class QuoteOwner
{
    /**
     * @Groups({"owner_api"})
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @Groups({"owner_api"})
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank(message="Author name cannot be blank")
     * @Assert\Length(max="30", maxMessage="Author name must be less than 30 caracters")
     */
    private $fullname;
    /**
     * @ORM\OneToMany(targetEntity="Quote", mappedBy="owner")
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


    public function addQuote(Quote $quote): void
    {
        $this->quotes->add($quote);
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function getQuotes()
    {
        return $this->quotes;
    }







}