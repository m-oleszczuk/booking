<?php

declare(strict_types=1);

namespace App\Reservation\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="room")
 */
class Room
{
    /**
     * @Groups("reservation")
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Groups("reservation")
     * @Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @Groups("reservation")
     * @Column(name="premium", type="boolean", nullable=false)
     */
    private $isPremium;

    /**
     * @OneToMany(targetEntity="Reservation", mappedBy="room")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getIsPremium()
    {
        return $this->isPremium;
    }

    /**
     * @param mixed $isPremium
     */
    public function setIsPremium($isPremium): void
    {
        $this->isPremium = $isPremium;
    }

    public function getReservations() {
        return $this->reservations;
    }
}