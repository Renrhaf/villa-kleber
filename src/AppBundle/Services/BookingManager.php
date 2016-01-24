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
            ->setSubject('Hello Email')
            ->setFrom('no-reply@villa-kleber.fr')
            ->setTo('admin@villa-kleber.fr')
            ->setBody(
                $this->templating->render(
                    'booking/emails/save_notification.html.twig',
                    array('booking' => $booking)
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}
