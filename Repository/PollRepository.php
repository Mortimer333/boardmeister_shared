<?php

namespace Shared\Repository;

use App\Service\ValidationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Shared\Entity\Poll;
use Shared\Trait\PaginationTrait;

/**
 * @extends ServiceEntityRepository<Poll>
 *
 * @method Poll|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poll|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poll[]    findAll()
 * @method Poll[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollRepository extends ServiceEntityRepository
{
    use PaginationTrait;

    public function __construct(
        ManagerRegistry $registry,
        protected ValidationService $validationService,
    ) {
        parent::__construct($registry, Poll::class);
    }

    public function save(Poll $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Poll $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findChoice(Poll $poll, string $ip): ?Poll\Choice
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $result = $qb->select('c.id')
            ->from(Poll::class, 'p')
            ->where('p.id = :id')
            ->setParameter('id', $poll->getId())
            ->innerJoin('p.options', 'o')
            ->innerJoin('o.choices', 'c')
            ->andWhere('c.ip = :ip')
            ->setParameter('ip', $ip)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (!$result) {
            return null;
        }

        return $em->getRepository(Poll\Choice::class)->find($result['id']);
    }

//    /**
//     * @return Poll[] Returns an array of Poll objects
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

//    public function findOneBySomeField($value): ?Poll
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
