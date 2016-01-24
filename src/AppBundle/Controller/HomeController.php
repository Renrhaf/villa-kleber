<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default controller.
 * Deals with main site pages.
 */
class HomeController extends Controller
{
    /**
     * Homepage.
     *
     * @Route("/", name="homepage")
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
