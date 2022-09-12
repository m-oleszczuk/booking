<?php

namespace App\DataFixtures;

use App\Reservation\Domain\Entity\Holder;
use App\Reservation\Domain\Entity\Reservation;
use App\Reservation\Domain\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReservationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $holderEntity1 = new Holder();
        $holderEntity1->setFirstName('John');
        $holderEntity1->setLastName('Doe');
        $holderEntity1->setEmail('john.doe@gmail.com');
        $holderEntity1->setPhoneNumber('999888777');
        $manager->persist($holderEntity1);

        $holderEntity2 = new Holder();
        $holderEntity2->setFirstName('Jane');
        $holderEntity2->setLastName('Schmoe');
        $holderEntity2->setEmail('janey20@wp.pl');
        $holderEntity2->setPhoneNumber('+48666555777');
        $manager->persist($holderEntity2);

        $reservation1 = new Reservation();
        $reservation1->setStartDate(new \DateTimeImmutable('2020-10-10'));
        $reservation1->setEndDate(new \DateTimeImmutable('2020-10-12'));
        $reservation1->setConfirmed(true);
        $reservation1->setHolder($holderEntity1);
        $reservation1->setTotalCost(10000);

        $reservation2 = new Reservation();
        $reservation2->setStartDate(new \DateTimeImmutable('2020-10-10'));
        $reservation2->setEndDate(new \DateTimeImmutable('2020-10-12'));
        $reservation2->setConfirmed(true);
        $reservation2->setHolder($holderEntity2);
        $reservation2->setTotalCost(10000);

        $roomEntity1 = new Room();
        $roomEntity1->setIsPremium(true);
        $roomEntity1->setNumber(1);
        $manager->persist($roomEntity1);

        $roomEntity2 = new Room();
        $roomEntity2->setIsPremium(false);
        $roomEntity2->setNumber(2);
        $manager->persist($roomEntity2);

        $roomEntity1->getReservations()->add($reservation1);
        $reservation1->setRoom($roomEntity1);

        $roomEntity2->getReservations()->add($reservation2);
        $reservation2->setRoom($roomEntity2);

        $manager->persist($reservation1);
        $manager->persist($reservation2);

        $manager->flush();
    }
}
