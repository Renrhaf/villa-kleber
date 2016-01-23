<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends Controller
{
    /**
     * @Route("/reservation", name="booking")
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


            return $this->redirectToRoute('task_success');
        }

        return $this->render('booking/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
