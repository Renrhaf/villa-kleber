<?php

namespace AppBundle\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validator for booking for a room in a period of dates.
 * If a booking already exists, refuse.
 */
class UniqueInPeriodValidator extends ConstraintValidator
{
    // Dependencies.
    protected $em;
    protected $translator;

    /**
     * UniqueInPeriodValidator constructor.
     */
    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * Check if a booking already exists.
     */
    public function validate($booking, Constraint $constraint)
    {
        $existing = $this->em->getRepository('AppBundle:Booking')->findExisting($booking);
        if (!empty($existing)) {
            $this->context->buildViolation($this->translator->trans($constraint->message))
                ->atPath('fromDate')
                ->addViolation();
        }
    }
}