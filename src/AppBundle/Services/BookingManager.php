<?php

namespace AppBundle\Services;

use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Manager to save bookings.
 */
class BookingManager
{
    // Dependencies.
    protected $em;
    protected $translator;
    protected $mailer;
    protected $templating;

    /**
     * BookingType constructor.
     */
    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator, \Swift_Mailer $mailer, TwigEngine $templating)
    {
        $this->em = $em;
        $this->translator = $translator;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Save the booking, send a mail to administrator for validation.
     *
     * @param Booking $booking
     */
    public function save(Booking $booking) {
        // Save to Database.
        $this->em->persist($booking);
        $this->em->flush($booking);

        // Send the email.
        $message = \Swift_Message::newInstance()
            ->setSubject('Nouvelle demande de réservation - Villa Kleber')
            ->setFrom('no-reply@villa-kleber-strasbourg.fr')
            ->setTo('admin@villa-kleber-strasbourg.fr')
            ->setBody(
                $this->templating->render(
                    'booking/emails/notification.html.twig',
                    array('booking' => $booking)
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    /**
     * Confirm the booking, send a mail to customer.
     *
     * @param Booking $booking
     *
     * @throws \Exception
     *   If an already confirmed booking exists.
     */
    public function confirm(Booking $booking)
    {
        // Check for existing confirmed bookings.
        $conflicts = $this->getConflicting($booking, true);
        if (!empty($conflicts)) {
            $conflict = array_shift($conflicts);
            throw new \Exception('Conflicting with one already confirmed booking : ' . $conflict->getId());
        }

        // Confirm the booking.
        $booking->setValidated(true);
        $booking->setReviewed(true);

        // Save to Database.
        $this->em->persist($booking);
        $this->em->flush($booking);

        // Send the email.
        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation de réservation - Villa Kleber')
            ->setFrom('no-reply@villa-kleber-strasbourg.fr')
            ->setTo($booking->getEmail())
            ->setBody(
                $this->templating->render(
                    'booking/emails/confirmation.html.twig',
                    array('booking' => $booking)
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    /**
     * Search a booking happening on the given day.
     *
     * @param \DateTime $day
     *   The day to search booking for.
     * @param array $bookings
     *   The list of bookings to search in.
     * @param boolean $unique
     *   Only keep one booking per day ?
     *
     * @return array
     *   If there is one or more bookings on this day.
     */
    public function getBookingForThisDay(\DateTime $day, array $bookings, $unique = TRUE)
    {
        $result = array();

        // Set day to one minute after last night departure.
        $day->setTime(12, 0, 0);

        foreach ($bookings as $booking) {
            if ($booking->getFromDate() <= $day && $booking->getToDate() >= $day) {
                if ($unique) {
                    $result[$booking->getRoom()] = $booking;
                } else {
                    $result[$booking->getId()] = $booking;
                }
            }
        }

        return $result;
    }

    /**
     * Return any colliding booking with the given one.
     *
     * @param boolean $confirmed
     *   Only check for confirmed bookings ?
     *
     * @return array
     *   A list of bookings.
     */
    public function getConflicting(Booking $booking, $confirmed = true)
    {
        return $this->em->getRepository('AppBundle:Booking')->findExisting($booking, $confirmed);
    }
}
