<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order implements \JsonSerializable
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $orderCode;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $productId;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date")
     */
    private $shippingDate;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  int  $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getOrderCode(): string
    {
        return $this->orderCode;
    }

    /**
     * @param  string  $orderCode
     */
    public function setOrderCode(string $orderCode): void
    {
        $this->orderCode = $orderCode;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param  int  $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param  int  $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param  string  $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return \DateTime|null
     */
    public function getShippingDate(): ?\DateTime
    {
        return $this->shippingDate;
    }

    /**
     * @param  \DateTime|null  $shippingDate
     */
    public function setShippingDate(?\DateTime $shippingDate): void
    {
        $this->shippingDate = $shippingDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param  \DateTime|null  $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'orderCode' => $this->getOrderCode(),
            'productId' => $this->getProductId(),
            'quantity' => $this->getQuantity(),
            'address' => $this->getAddress(),
            'shippingDate' => $this->getShippingDate(),
            'createdAt' => $this->getCreatedAt(),
        ];
    }
}