<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param  string  $username
     * @param  string  $email
     * @return mixed
     */
    public function userHasRegistered(string $username, string $email)
    {
        return $this->createQueryBuilder('users')
            ->orWhere('users.username = :username')
            ->orWhere('users.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $email)
            ->getQuery()
            ->execute();
    }
}