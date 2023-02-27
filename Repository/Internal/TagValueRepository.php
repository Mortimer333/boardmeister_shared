<?php

namespace Shared\Repository\Internal;

use App\Service\ValidationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Shared\Entity\Internal\TagValue;
use Shared\Trait\PaginationTrait;

/**
 * @extends ServiceEntityRepository<TagValue>
 *
 * @method TagValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagValue[]    findAll()
 * @method TagValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagValueRepository extends ServiceEntityRepository
{
    use PaginationTrait;

    public function __construct(
        ManagerRegistry $registry,
        protected ValidationService $validationService,
    ) {
        parent::__construct($registry, TagValue::class);
    }

    public function save(TagValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TagValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TagValue[] Returns an array of TagValue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TagValue
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
