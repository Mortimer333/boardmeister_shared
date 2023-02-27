<?php

namespace Shared\Repository\Internal;

use App\Service\ValidationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Shared\Entity\Internal\DiaryEntry;
use Shared\Trait\PaginationTrait;

/**
 * @extends ServiceEntityRepository<DiaryEntry>
 *
 * @method DiaryEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiaryEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiaryEntry[]    findAll()
 * @method DiaryEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiaryEntryRepository extends ServiceEntityRepository
{
    use PaginationTrait;

    public function __construct(
        ManagerRegistry $registry,
        protected ValidationService $validationService,
    ) {
        parent::__construct($registry, DiaryEntry::class);
    }

    public function save(DiaryEntry $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DiaryEntry $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DiaryEntry[] Returns an array of DiaryEntry objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DiaryEntry
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
