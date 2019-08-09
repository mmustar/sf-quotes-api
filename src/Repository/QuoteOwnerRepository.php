<?php


namespace App\Repository;


use App\Entity\QuoteOwner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class QuoteOwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuoteOwner::class);
    }

    public function save(QuoteOwner $owner) : void
    {
        $this->getEntityManager()->persist($owner);
        $this->getEntityManager()->flush();
    }

    public function delete(QuoteOwner $owner) : void
    {
        $this->getEntityManager()->remove($owner);
        $this->getEntityManager()->flush();
    }

}