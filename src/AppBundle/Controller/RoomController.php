<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Room controller.
 * Deals with room pages.
 */
class RoomController extends Controller
{
    /**
     * Rubis room page.
     */
    public function redRoomAction()
    {
        // Prepare the booking form.
        $booking = new Booking();
        $booking->setRoom('red');

        $form = $this->createForm(BookingType::class, $booking, array(
            'action' => $this->generateUrl('booking'),
            'method' => 'POST',
        ));

        return $this->render('rooms/red.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Opale room page.
     */
    public function greenRoomAction()
    {
        // Prepare the booking form.
        $booking = new Booking();
        $booking->setRoom('green');

        $form = $this->createForm(BookingType::class, $booking, array(
            'action' => $this->generateUrl('booking'),
            'method' => 'POST',
        ));

        return $this->render('rooms/green.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Saphir room page.
     */
    public function blueRoomAction(Request $request)
    {
        // Prepare the booking form.
        $booking = new Booking();
        $booking->setRoom('blue');

        $form = $this->createForm(BookingType::class, $booking, array(
            'action' => $this->generateUrl('booking'),
            'method' => 'POST',
        ));

        return $this->render('rooms/blue.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
