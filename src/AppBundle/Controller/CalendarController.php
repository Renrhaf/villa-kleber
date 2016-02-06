<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Calendar controller.
 * Manage pages dealing with the calendar.
 */
class CalendarController extends Controller
{
    /**
     * Renders the calendar.
     */
    public function renderAction(Request $request)
    {
        // Get parameters.
        $room = $request->query->get('room', null);  // Set a room to display booking for.
        $date = $request->query->get('date', null);  // Set a date to display calendar for (m/y)
        $date = \DateTime::createFromFormat('m/Y', $date);
        if (!$date) {
            $date = new \DateTime('now');
        }

        // Compute start and ending dates.
        $start = clone $date;
        $start = $date->modify('first day of this month');
        $start->setTime(0, 0, 0);
        $end = clone $date;
        $end = $end->modify('last day of this month');
        $end->setTime(23, 59, 59);

        // Calendar dates.
        $startCalendar = clone $start;
        $startCalendar = $startCalendar->modify('previous monday');
        $endCalendar = clone $end;
        $endCalendar = $endCalendar->modify('next monday');

        // Calendar period.
        $period = new \DatePeriod($startCalendar, \DateInterval::createFromDateString('1 day'), $endCalendar);

        // Get bookings.
        $bookings = $this->getDoctrine()->getManager()->getRepository('AppBundle:Booking')->findForCalendar(
            $startCalendar,
            $endCalendar,
            $room
        );

        return $this->render('calendar/calendar.html.twig', array(
            'start' => $start,
            'end' => $end,
            'startCalendar' => $startCalendar,
            'endCalendar' => $endCalendar,
            'room' => $room,
            'bookings' => $bookings,
            'period' => $period,
            'bookingManager' => $this->get('app.booking.manager')
        ));
    }
}
