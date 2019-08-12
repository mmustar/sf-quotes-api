<?php


namespace App\Repository;


use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function save(Quote $quote) : void
    {
        $this->getEntityManager()->persist($quote);
        $this->getEntityManager()->flush();
    }

    public function delete(Quote $quote) : void
    {
        $this->getEntityManager()->remove($quote);
        $this->getEntityManager()->flush();
    }

}