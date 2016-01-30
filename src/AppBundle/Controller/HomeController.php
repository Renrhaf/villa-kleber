<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
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

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
