<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Model\Write;

use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Domain\Service\BookingCostService;
use App\Reservation\Entity\Holder;
use App\Reservation\Entity\Reservation as ReservationEntity;
use App\Reservation\Entity\Room;
use App\Shared\Application\Exception\InfrastructureException;
use App\Shared\Application\Exception\NotFoundException;
use App\Reservation\Application\Model\Write\ReservationWriteInterface;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use App\Reservation\Infrastructure\Exception\ReservationException;
use Throwable;

class ReservationWriteRepository implements ReservationWriteInterface
{
    public function __construct(
        private Connection $connection,
        private EntityManagerInterface $entityManager,
        private BookingCostService $bookingCostService,
    ) {}

    /** @throws NotFoundException|InfrastructureException|ReservationException
     */
    public function create(Reservation $reservationDto): void
    {
        if ($this->isRoomReserved(
            $reservationDto->startDate,
            $reservationDto->endDate,
            $reservationDto->room->number,
        )) {
            throw ReservationException::roomReserved(
                $reservationDto->startDate,
                $reservationDto->endDate,
                $reservationDto->room->number,
            );
        }

        $holderEntity = $this->getOrCreateHolderEntity($reservationDto);
        $reservationEntity = $this->prepareReservationEntity($reservationDto, $holderEntity, null);

        $this->entityManager->persist($reservationEntity);
        $this->entityManager->flush();
    }

    /** @throws NotFoundException|InfrastructureException */
    public function update(int $oldReservationId, Reservation $newReservation): void
    {
        $reservation = $this->entityManager
            ->getRepository(ReservationEntity::class)
            ->find($oldReservationId);

        if (!$reservation) {
            throw NotFoundException::resourceNotFound();
        }

        if (
            $reservation->getStartDate() !== $newReservation->startDate ||
            $reservation->getEndDate() !== $newReservation->endDate
        ) {
            $this->isRoomReserved($newReservation->startDate, $newReservation->endDate, $newReservation->room->number);
        }

        $holderEntity = $this->getOrCreateHolderEntity($newReservation);
        $this->prepareReservationEntity($newReservation, $holderEntity, $reservation);

        $this->entityManager->flush();
    }

    /** @throws NotFoundException */
    public function delete(int $reservationId): void
    {
        $reservation = $this->entityManager
            ->getRepository(ReservationEntity::class)
            ->find($reservationId);

        if (!$reservation) {
            throw NotFoundException::resourceNotFound();
        }

        $this->entityManager->remove($reservation);
        $this->entityManager->flush();
    }

    /** @throws NotFoundException|InfrastructureException */
    private function isRoomReserved(DateTimeImmutable $startDate, DateTimeImmutable $endDate, int $roomNumber): bool
    {
        try {
            $roomQueryBuilder = $this->connection->createQueryBuilder();
            $roomQueryBuilder->select('r.id')
                ->from('room', 'r')
                ->where(sprintf("r.number = %s", $roomNumber))
                ->getFirstResult();

            $room = $roomQueryBuilder->executeQuery()->fetchAssociative();

            if (!$room) {
                throw NotFoundException::resourceNotFound();
            }

            $roomReservationQueryBuilder = $this->connection->createQueryBuilder();

            $roomReservationQueryBuilder->select("COUNT(*)")
                ->from('reservation', 'r')
                ->where(sprintf('r.room_id = %s', $room['id']))
                ->andWhere(
                    sprintf(
                        '(start_date, end_date) OVERLAPS (DATE \'%s\', DATE \'%s\')',
                        $startDate->format('Y-m-d H:i:s'),
                        $endDate->format('Y-m-d H:i:s'),
                    ),
                );

            return $roomReservationQueryBuilder->executeQuery()->fetchOne() > 0;
        } catch (NotFoundException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            throw InfrastructureException::unexpectedError($exception);
        }
    }

    private function getOrCreateHolderEntity(Reservation $newReservation): Holder
    {
        $holderEntity = $this->entityManager
            ->getRepository(Holder::class)
            ->findOneBy([
                'email' => $newReservation->holder->email
            ]);

        if (!$holderEntity) {
            $holderEntity = new Holder();
            $holderEntity->setFirstName($newReservation->holder->firstName);
            $holderEntity->setLastName($newReservation->holder->lastName);
            $holderEntity->setEmail($newReservation->holder->email);
            $holderEntity->setPhoneNumber($newReservation->holder->phoneNumber);

            $this->entityManager->persist($holderEntity);
        }

        return $holderEntity;
    }

    /** @throws NotFoundException */
    private function prepareReservationEntity(
        Reservation $newReservation, Holder $holderEntity, ?ReservationEntity $reservation
    ): ReservationEntity
    {
        if (!$reservation) {
            $reservation = new ReservationEntity();
        }

        $roomEntity = $this->entityManager
            ->getRepository(Room::class)
            ->findOneBy([
                'number' => $newReservation->room->number
            ]);

        if (!$roomEntity) {
            throw NotFoundException::resourceNotFound();
        }

        $reservation->setStartDate($newReservation->startDate);
        $reservation->setEndDate($newReservation->endDate);
        $reservation->setConfirmed($newReservation->confirmed);
        $reservation->setHolder($holderEntity);
        $reservation->setTotalCost(
            $this->bookingCostService->bookingCost(
                $roomEntity->getIsPremium(),
                $newReservation->startDate,
                $newReservation->endDate,
            )
        );

        $roomEntity->getReservations()->add($reservation);
        $reservation->setRoom($roomEntity);

        $this->entityManager->persist($reservation);
        return $reservation;
    }
}