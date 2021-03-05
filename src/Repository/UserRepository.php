<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[]
     */
    public function findUserWithoutFilter($page){
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->setFirstResult(10 * ($page - 1))
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[]
     */
    public function findBySearch($value, $page, $limit){
        $builder = $this->createQueryBuilder('u')
            ->orWhere("u.nom LIKE :val")
            ->orWhere("u.email LIKE :val")
            ->orWhere("u.telephone LIKE REPLACE(:val, ' ', '+')")
            ->orWhere("REPLACE(REPLACE(u.roles, 'ROLE_ADMIN', 'administrateur'), 'ROLE_USER', 'utilisateur') LIKE :val")
            ->orWhere("IFNULL(u.confirmationToken, 'confirmé') LIKE :val")
            ->orWhere("REPLACE(u.confirmationToken, u.confirmationToken, 'en attente') LIKE :val")
            ->orWhere("u.solde LIKE :val")
            ->orWhere("DATE_FORMAT(u.date_crea, '%d-%m-%Y') LIKE :val")
            ->orWhere("DATE_FORMAT(u.date_fin, '%d-%m-%Y') LIKE :val")
            ->setParameter('val', "%".$value."%")
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        if($value == null){
            $result = $builder->orderBy('u.id', 'DESC')->getQuery()->getResult();
        }
        else{
            $result = $builder->getQuery()->getResult();
        }

        return $result;
    }

    /**
     * @return int
     */
    public function countBySearch($value){
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->orWhere("u.nom LIKE :val")
            ->orWhere("u.email LIKE :val")
            ->orWhere("u.telephone LIKE REPLACE(:val, ' ', '+')")
            ->orWhere("REPLACE(REPLACE(u.roles, 'ROLE_ADMIN', 'administrateur'), 'ROLE_USER', 'utilisateur') LIKE :val")
            ->orWhere("IFNULL(u.confirmationToken, 'confirmé') LIKE :val")
            ->orWhere("REPLACE(u.confirmationToken, u.confirmationToken, 'en attente') LIKE :val")
            ->orWhere("u.solde LIKE :val")
            ->orWhere("DATE_FORMAT(u.date_crea, '%d-%m-%Y') LIKE :val")
            ->orWhere("DATE_FORMAT(u.date_fin, '%d-%m-%Y') LIKE :val")
            ->setParameter('val', "%".$value."%")
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
