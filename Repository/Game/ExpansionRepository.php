<?php

namespace Shared\Repository\Game;

use App\Service\ValidationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Shared\Entity\Game\Expansion;
use Shared\Trait\PaginationTrait;

/**
 * @extends ServiceEntityRepository<Expansion>
 *
 * @method Expansion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expansion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expansion[]    findAll()
 * @method Expansion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpansionRepository extends ServiceEntityRepository
{
    use PaginationTrait;

    public function __construct(
        ManagerRegistry $registry,
        protected ValidationService $validationService,
    ) {
        parent::__construct($registry, Expansion::class);
    }

    public function save(Expansion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Expansion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Expansion[] Returns an array of Expansion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Expansion
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
