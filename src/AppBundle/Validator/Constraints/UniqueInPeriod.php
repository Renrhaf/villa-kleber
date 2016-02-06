<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Validator to check if there is no reservation in a period of dates.
 *
 * @Annotation
 */
class UniqueInPeriod extends Constraint
{
    public $message = 'booking.already.existing';

    public function validatedBy()
    {
        return 'unique_in_period';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}