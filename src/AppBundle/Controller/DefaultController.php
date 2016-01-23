<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
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

    /**
     * @Route("/chambre/rubis", name="room_red")
     */
    public function redRoomAction(Request $request)
    {
        return $this->render('rooms/red.html.twig');
    }

    /**
     * @Route("/chambre/jade", name="room_green")
     */
    public function greenRoomAction(Request $request)
    {
        return $this->render('rooms/green.html.twig');
    }

    /**
     * @Route("/chambre/saphir", name="room_blue")
     */
    public function blueRoomAction(Request $request)
    {
        return $this->render('rooms/blue.html.twig');
    }
}
