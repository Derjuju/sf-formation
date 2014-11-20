<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PlayerRepository extends EntityRepository
{
    public function getLastRegisteredPlayer()
    {
        return $this->createQueryBuilder('p')
                ->select('p.id, p.username')
                ->where('p.isActive = :active')
                ->orderBy('p.id', 'DESC')
                ->setParameters(['active'=>1])
                ->getQuery()
                ->getResult()
            ;
    }
}
