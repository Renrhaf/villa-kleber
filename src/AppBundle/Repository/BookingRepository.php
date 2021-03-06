<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityRepository;

/**
 * BookingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends EntityRepository
{
    /**
     * Find bookings for given room and dates.
     *
     * @param Booking $booking
     *   The booking to get data from.
     * @param boolean $validated
     *   Only check for validated bookings if true.
     *
     * @return array
     *   All bookings for given room and dates.
     */
    public function findExisting(Booking $booking, $validated = true)
    {
        return $this->findExistingExplicit($booking->getRoom(), $booking->getFromDate(), $booking->getToDate(), $validated, array($booking->getId()));
    }

    /**
     * Find bookings for given room and dates.
     *
     * @param string $room
     *   The room.
     * @param \DateTime $from
     * @param \DateTime $to
     * @param boolean $validated
     *   Only check for validated bookings if true.
     * @param array $exclude
     *   Ids to exclude.
     *
     * @return array
     *   All bookings for given room and dates.
     */
    public function findExistingExplicit($room, \DateTime $from, \DateTime $to, $validated, $exclude)
    {
        $qb = $this->createQueryBuilder('booking')
            ->andWhere('booking.room = :room')
            ->andWhere('
                (booking.fromDate >= :start AND booking.fromDate <= :end)
                OR (booking.toDate >= :start AND booking.toDate <= :end)
                OR (booking.fromDate <= :start AND booking.toDate >= :end)
                OR (booking.fromDate >= :start AND booking.toDate <= :end)
            ')
            ->andWhere('booking.id NOT IN (:ids)')
            ->setParameter('room', $room)
            ->setParameter('start', $from)
            ->setParameter('end', $to)
            ->setParameter('ids', $exclude);

        if ($validated) {
            $qb
                ->andWhere('booking.validated = :validated')
                ->setParameter('validated', true);
        }

        return $qb->getQuery()->getResult();
    }


    /**
     * Find bookings to display the calendar.
     *
     * @param \DateTime $start
     * @param \DateTime $end
     * @param string $room
     *   The room to filter with, can be null.
     *
     * @return array
     *   The bookings to display the calendar.
     */
    public function findForCalendar(\DateTime $start, \DateTime $end, $room = null)
    {
        $qb = $this->createQueryBuilder('booking')
            ->andWhere('
                (booking.fromDate >= :start AND booking.fromDate <= :end)
                OR (booking.toDate >= :start AND booking.toDate <= :end)
                OR (booking.fromDate <= :start AND booking.toDate >= :end)
                OR (booking.fromDate >= :start AND booking.toDate <= :end)
            ')
            ->setParameter('start', $start)
            ->setParameter('end', $end);

        if (!is_null($room)) {
            $qb
                ->andWhere('booking.room = :room')
                ->setParameter('room', $room);
        }

        return $qb->getQuery()->getResult();
    }
}
