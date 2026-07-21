<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * Recherche un livre par titre, nom d'auteur ou nom de catégorie
     */
    public function findBySearch(?string $query): array
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.auteur', 'a')
            ->leftJoin('l.categorie', 'c');

        if ($query) {
            $qb->where('l.titre LIKE :q')
               ->orWhere('a.nom LIKE :q')
               ->orWhere('c.nom LIKE :q')
               ->setParameter('q', '%' . $query . '%');
        }

        return $qb->getQuery()->getResult();
    }
}