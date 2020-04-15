<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    /**
     * OrderRepository constructor.
     * @param  ManagerRegistry  $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param  string  $orderCode
     * @param  string  $shippingDate
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function updateShippingDateByOrderCode(string $orderCode, string $shippingDate)
    {
        return $this->createQueryBuilder('orders')
            ->update()
            ->set('shipping_date', 'shippingDate')
            ->setParameter('shippingDate', $shippingDate)
            ->where('order_code = :orderCode')
            ->setParameter('orderCode', $orderCode)
            ->getQuery()
            ->getSingleScalarResult();
    }
}