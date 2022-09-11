<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Model\Read;

use Doctrine\DBAL\Connection;
use App\Reservation\Application\Dto\Reservation;
use App\Reservation\Application\Factory\ReservationFactory;
use App\Reservation\Application\Model\Read\ReservationInterface;
use App\Shared\Application\Exception\InfrastructureException;
use App\Shared\Application\Exception\NotFoundException;
use App\Shared\Application\ValueObject\Pagination;
use Throwable;

class DbalReservations implements ReservationInterface
{
    public function __construct(private Connection $connection, private ReservationFactory $factory) {}

    /**
     * @return Reservation[]
     * @throws InfrastructureException
     */
    public function getAllReservations(Pagination $pagination): array
    {
        try {
            $queryBuilder = $this->connection->createQueryBuilder();

            $queryBuilder->select(
                'r.start_date', 'r.end_date',
                'rh.first_name', 'rh.last_name', 'rh.phone_number', 'rh.email',
                'ro.number', 'ro.premium', 'r.confirmed'
            )->from('reservation', 'r')
            ->leftJoin('r', 'reservation_holder', 'rh', 'r.holder_id = rh.id')
            ->leftJoin('r', 'room', 'ro', 'r.room_id = ro.id')
            ->setFirstResult($pagination->offset())
            ->setMaxResults($pagination->limit());

            $reservationData = $queryBuilder->executeQuery()->fetchAllAssociative();

            if (!$reservationData) {
                return [];
            }
            return array_map([$this->factory, 'createReservation'], $reservationData);
        } catch (Throwable $exception) {
            throw InfrastructureException::unexpectedError($exception);
        }
    }

    /** @throws InfrastructureException|NotFoundException */
    public function getReservation(int $id): Reservation
    {
        try {
            $queryBuilder = $this->connection->createQueryBuilder();

            $queryBuilder->select(
                'r.start_date', 'r.end_date',
                'rh.first_name', 'rh.last_name', 'rh.phone_number', 'rh.email',
                'ro.number', 'ro.premium', 'r.confirmed'
            )->from('reservation', 'r')
                ->leftJoin('r', 'reservation_holder', 'rh', 'r.holder_id = rh.id')
                ->leftJoin('r', 'room', 'ro', 'r.room_id = ro.id')
                ->where(sprintf("r.id = %s", $id));

            $reservationData = $queryBuilder->executeQuery()->fetchAssociative();

            if (!$reservationData) {
                throw NotFoundException::resourceNotFound();
            }

            return $this->factory->createReservation($reservationData);
        } catch (NotFoundException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            throw InfrastructureException::unexpectedError($exception);
        }
    }
//
//    /**
//     * @return Reservation[]
//     * @throws InfrastructureException|NotFoundException
//     */
//    public function getReservationsForRoom(Pagination $pagination, Room $room): array
//    {
//        try {
//            $queryBuilder = $this->connection->createQueryBuilder();
//
//            $queryBuilder->select(
//                'r.start_date', 'r.end_date',
//                'rh.first_name', 'rh.last_name', 'rh.alias', 'rh.phone', 'rh.email',
//                'rr.number AS room_number', 'r.confirmed'
//            )->from('room_reservation', 'rr')
//                ->leftJoin('rr', 'reservation', 'r', 'rr.reservation_id = r.id')
//                ->leftJoin('r', 'reservation_holder', 'rh', 'r.reservation_holder_id = rh.id')
//                ->where('rr.number = :number')
//                ->setParameter('number', $room->number);
//
//            $reservationData = $queryBuilder->executeQuery()->fetchAllAssociative();
//
//            if (!$reservationData) {
//                throw NotFoundException::resourceNotFound();
//            }
//
//            return array_map([$this->factory, 'createReservation'], $reservationData);
//        } catch (NotFoundException $exception) {
//            throw $exception;
//        } catch (Throwable $exception) {
//            throw InfrastructureException::unexpectedError($exception);
//        }
//    }

//    /**
//     * @return Reservation[]
//     * @throws InfrastructureException|NotFoundException
//     */
//    public function getReservationsForRoomInDateRange(Pagination $pagination, Room $room, ReservationDates $reservationDates): array
//    {
//        try {
//            $queryBuilder = $this->connection->createQueryBuilder();
//
//            $queryBuilder->select(
//                'r.start_date', 'r.end_date',
//                'rh.first_name', 'rh.last_name', 'rh.alias', 'rh.phone', 'rh.email',
//                'rr.number AS room_number', 'r.confirmed'
//            )->from('room_reservation', 'rr')
//                ->leftJoin('rr', 'reservation', 'r', 'rr.reservation_id = r.id')
//                ->leftJoin('r', 'reservation_holder', 'rh', 'r.reservation_holder_id = rh.id')
//                ->where('rr.id = :id')
//                ->andWhere('r.start_date = :startDate')
//                ->andWhere('r.end_date = :endDate')
//                ->setParameters([
//                    ':id' => $roomReservation->roomNumber,
//                    ':startDate' => $roomReservation->startDate,
//                    ':endDate' => $roomReservation->endDate,
//                ]);
//
//            $reservationData = $queryBuilder->executeQuery()->fetchAllAssociative();
//
//            if (!$reservationData) {
//                throw NotFoundException::resourceNotFound();
//            }
//
//            return array_map([$this->factory, 'createReservation'], $reservationData);
//        } catch (NotFoundException $exception) {
//            throw $exception;
//        } catch (Throwable $exception) {
//            throw InfrastructureException::unexpectedError($exception);
//        }
//    }

//    /**
//     * @return Reservation[]
//     * @throws InfrastructureException
//     */
//    public function getReservationsForDateRange(Pagination $pagination, ReservationDates $dates): array
//    {
//        try {
//            $queryBuilder = $this->connection->createQueryBuilder();
//
//            $queryBuilder->select(
//                'r.start_date', 'r.end_date',
//                'rh.first_name', 'rh.last_name', 'rh.alias', 'rh.phone', 'rh.email',
//                'rr.number AS room_number', 'r.confirmed'
//            )->from('reservation', 'r')
//                ->leftJoin('r', 'reservation_holder', 'rh', 'r.reservation_holder_id = rh.id')
//                ->leftJoin('r', 'room_reservation', 'rr', 'r.id = rr.reservation_id')
//                ->where('r.start_date >= :startDate')
//                ->andWhere('r.end_date <= :endDate')
//                ->setFirstResult($pagination->offset())
//                ->setMaxResults($pagination->limit())
//                ->setParameters([
//                    'startDate' => $dates->startDate(),
//                    'endDate' => $dates->endDate(),
//                ]);
//
//            $reservationData = $queryBuilder->executeQuery()->fetchAllAssociative();
//
//            if (!$reservationData) {
//                return [];
//            }
//
//            return array_map([$this->factory, 'createReservation'], $reservationData);
//        } catch (Throwable $exception) {
//            throw InfrastructureException::unexpectedError($exception);
//        }
//    }
}