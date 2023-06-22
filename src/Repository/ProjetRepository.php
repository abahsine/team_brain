<?php

namespace App\Repository;

use App\Entity\Projet;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 *
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    public function save(Projet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Projet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getMesProjets(User $user)
    {
        $qb = $this->createQueryBuilder("p")
            ->leftJoin("p.inscriptions", "i")
            ->where('i.user = :user')
            ->orWhere("p.Owner = :user")
            ->setParameters(array('user' => $user));
        return $qb->getQuery()->getResult();
    }

    public function searchProjets(string $search = '')
    {
        $qb = $this->createQueryBuilder("p");
        $qb
            ->leftJoin('p.skills', 's')
            ->where("p.titre like :search or p.description like :search or s.tag like :search")
            ->andWhere('p.id NOT IN (' . $this->incomplete()->getDQL() . ')')
            ->setParameters(['search' => '%' . $search . '%']);

        return $qb->getQuery();
    }

    public function incomplete()
    {
        $qb = $this->createQueryBuilder("p1")
            ->select("p1.id")
            ->leftJoin('p1.inscriptions', 'i2')
            ->groupBy('p1.id')
            ->having('count(i2)>=3');
        return $qb->getQuery();
    }

//    /**
//     * @return Projet[] Returns an array of Projet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Projet
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
