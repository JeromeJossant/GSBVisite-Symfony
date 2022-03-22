<?php

namespace App\Repository;

use App\Entity\Medecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medecin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medecin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medecin[]    findAll()
 * @method Medecin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medecin::class);
    }

    /**
     * @return Medecin[] Returns an array of Medecin objects
     */

    public function findMedecinByNom(string $nom): array
    {
        // sous dossier symfony pour que lui gere les entity passé
   $entityManager = $this->getEntityManager();

   //requete sql pour récuperer le nom du medecin par son début de prénom
        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Medecin a
            WHERE a.nom LIKE :nom
            '
        )->setParameter('nom', $nom.'%');

        return $query->getResult();
    }

}
