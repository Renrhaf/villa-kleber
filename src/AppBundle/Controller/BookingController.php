<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Booking controller.
 * Manage pages dealing with booking.
 */
class BookingController extends Controller
{
    /**
     * Booking form page.
     */
    public function indexAction(Request $request)
    {
        // Prepare the booking form.
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking, array(
            'action' => $this->generateUrl('booking'),
            'method' => 'POST',
        ));

        // Handle request data.
        $form->handleRequest($request);

        // Check if form is valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the booking in the database.
            $bookingManager = $this->get('app.booking.manager');
            $bookingManager->save($booking);

            // Display the confirmation template.
            return $this->render('booking/confirm.html.twig', array(
              'booking' => $booking
            ));
        }

        return $this->render('booking/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
