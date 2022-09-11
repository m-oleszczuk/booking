<?php

declare(strict_types=1);

namespace App\Reservation\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservation_holder")
 */
class Holder
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
     * @Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @Groups("reservation")
     * @Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @Groups("reservation")
     * @Column(name="phone_number", type="string", length=25)
     */
    private $phoneNumber;

    /**
     * @Groups("reservation")
     * @Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @Groups("holder_detail")
     * @OneToMany(targetEntity="Reservation", mappedBy="holder", fetch="EXTRA_LAZY")
     */
    private $reservations;

    public function __construct() {
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return Collection
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    /**
     * @param Collection $reservations
     */
    public function setReservations(Collection $reservations): void
    {
        $this->reservations = $reservations;
    }
}