<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CarRequest extends BaseRequest
{
    const DEFAULT_LIMIT = 10;
    const SEATS_LIST = [4, 7, 16];
    const ORDER_TYPE_LIST = ['createdAt', 'price'];
    const ORDER_BY_LIST = ['asc', 'desc'];
    const DEFAULT_ORDER_TYPE = 'createdAt';
    const DEFAULT_ORDER_BY = 'desc';

    #[Assert\Type('string')]
    private $color;

    #[Assert\Type('string')]
    private $brand;

    #[Assert\Type('integer')]
    #[Assert\Choice(
        choices: self::SEATS_LIST,
    )]
    private $seats;

    #[Assert\Type('integer')]
    private int $limit = self::DEFAULT_LIMIT;


    #[Assert\Choice(
        choices: self::ORDER_TYPE_LIST,
    )]
    private string $orderType = self::DEFAULT_ORDER_TYPE;

    #[Assert\Choice(
        choices: self::ORDER_BY_LIST,
    )]
    private string $orderBy = self::DEFAULT_ORDER_BY;

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * @param mixed $seats
     */
    public function setSeats($seats): void
    {
        $this->seats = $seats;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getOrderType(): string
    {
        return $this->orderType;
    }

    /**
     * @param string $orderType
     */
    public function setOrderType(string $orderType): void
    {
        $this->orderType = $orderType;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }


}
