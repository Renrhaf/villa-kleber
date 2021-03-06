<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use AppBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default controller.
 * Deals with main site pages.
 */
class HomeController extends Controller
{
    /**
     * Homepage.
     */
    public function indexAction()
    {
        // Prepare the booking form.
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking, array(
            'action' => $this->generateUrl('booking'),
            'method' => 'POST',
        ));

        // Prepare the contact form.
        $contact = $this->createForm(ContactType::class, null, array(
          'action' => $this->generateUrl('contact'),
          'method' => 'POST',
        ));

        return $this->render('home/index.html.twig', array(
            'form' => $form->createView(),
            'contact' => $contact->createView()
        ));
    }
}
