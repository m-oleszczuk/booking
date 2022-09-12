<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Model\Read;

use Doctrine\DBAL\Connection;
use App\Reservation\Application\Dto\ReservationHolder;
use App\Reservation\Application\Factory\ReservationFactory;
use App\Reservation\Domain\Model\Read\ReservationHolderInterface;
use App\Shared\Application\Exception\InfrastructureException;
use App\Shared\Application\ValueObject\Pagination;
use Throwable;

class DbalReservationHolderRepository implements ReservationHolderInterface
{
    public function __construct(private Connection $connection, private ReservationFactory $factory) {}

    /**
     * @return ReservationHolder[]
     * @throws InfrastructureException
     */
    public function getAllReservationHolders(Pagination $pagination): array
    {
        try {
            $queryBuilder = $this->connection->createQueryBuilder();

            $queryBuilder->select(
                'rh.first_name', 'rh.last_name', 'rh.phone_number', 'rh.email',
            )->from('reservation_holder', 'rh')
                ->setFirstResult($pagination->offset())
                ->setMaxResults($pagination->limit());

            $reservationHolderData = $queryBuilder->executeQuery()->fetchAllAssociative();

            if (!$reservationHolderData) {
                return [];
            }

            return array_map([$this->factory, 'createReservationHolder'], $reservationHolderData);
        } catch (Throwable $exception) {
            throw InfrastructureException::unexpectedError($exception);
        }
    }
}