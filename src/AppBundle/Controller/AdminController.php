<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 * Deals with admin pages.
 */
class AdminController extends Controller
{
    /**
     * Admin home.
     * Display a list of bookings to confirm.
     *
     * @TODO pagination? filters?
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bm = $this->container->get('app.booking.manager');

        // Get booking waiting for confirmation.
        $waiting = $em->getRepository('AppBundle:Booking')->findBy(array(
            'reviewed' => false
        ));

        // Get all bookings
        $all = $em->getRepository('AppBundle:Booking')->findAll();

        return $this->render('admin/index.html.twig', array(
            'manager' => $bm,
            'waiting' => $waiting,
            'bookings' => $all,
        ));
    }

    /**
     * Confirms a booking.
     *
     * @param Booking $booking
     */
    public function confirmAction(Booking $booking)
    {
        $bm = $this->container->get('app.booking.manager');

        try {
            // Confirm the booking.
            $bm->confirm($booking);
        } catch(\Exception $e) {
            // @TODO set message.
        }

        // @TODO redirect to index controller.
    }
}
