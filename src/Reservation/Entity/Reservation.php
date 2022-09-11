<?php

declare(strict_types=1);

namespace App\Reservation\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservation")
 */
class Reservation
{
    /**
     * @Groups("reservation")
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     */
    private $id;

    /**
     * @Groups("reservation")
     * @Column(name="start_date", type="datetime_immutable", nullable=false)
     */
    private $startDate;

    /**
     * @Groups("reservation")
     * @Column(name="end_date", type="datetime_immutable", nullable=false)
     */
    private $endDate;

    /**
     * @Groups("reservation")
     * @ORM\ManyToOne(targetEntity="Holder", inversedBy="reservations")
     * @ORM\JoinColumn(name="holder_id", referencedColumnName="id")
     */
    private $holder;

    /**
     * @Groups("reservation")
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="reservations", fetch="EAGER")
     * @JoinColumn(name="room_id", referencedColumnName="id")
     */
    private $room;

    /**
     * @Groups("reservation")
     * @Column(name="total_cost", type="integer", nullable=false)
     */
    private $totalCost;

    /**
     * @Groups("reservation")
     * @Column(name="confirmed", type="boolean", nullable=false)
     */
    private $confirmed;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param DateTimeInterface $startDate
     */
    public function setStartDate(DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param DateTimeInterface $endDate
     */
    public function setEndDate(DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @param mixed $holder
     */
    public function setHolder($holder): void
    {
        $this->holder = $holder;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room): void
    {
        $this->room = $room;
    }

    /**
     * @return mixed
     */
    public function getTotalCost()
    {
        return $this->totalCost;
    }

    /**
     * @param mixed $totalCost
     */
    public function setTotalCost($totalCost): void
    {
        $this->totalCost = $totalCost;
    }

    /**
     * @return mixed
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param mixed $confirmed
     */
    public function setConfirmed($confirmed): void
    {
        $this->confirmed = $confirmed;
    }
}