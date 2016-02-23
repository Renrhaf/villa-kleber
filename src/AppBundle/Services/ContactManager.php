<?php

namespace AppBundle\Services;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Manager to save bookings.
 */
class ContactManager
{
    // Dependencies.
    protected $translator;
    protected $mailer;
    protected $templating;

    /**
     * BookingType constructor.
     */
    public function __construct(TranslatorInterface $translator, \Swift_Mailer $mailer, TwigEngine $templating)
    {
        $this->translator = $translator;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Send the contact mail.
     *
     * @param array $data
     */
    public function send(array $data) {
        $message = \Swift_Message::newInstance()
            ->setSubject('Nouveau message - Villa Kleber')
            ->setFrom('no-reply@villa-kleber-strasbourg.fr')
            ->setTo('admin@villa-kleber-strasbourg.fr')
            ->setBody(
                $this->templating->render(
                    'contact/emails/contact.html.twig',
                    array('contact' => $data)
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}
