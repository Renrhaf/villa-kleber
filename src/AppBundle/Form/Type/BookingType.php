<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Form type for Booking entity.
 */
class BookingType extends AbstractType
{
    // Dependencies.
    protected $translator;

    /**
     * BookingType constructor.
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Build the form.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname', TextType::class, array(
                'label' => $this->translator->trans('booking.fname.label'),
            ))
            ->add('lname', TextType::class, array(
                'label' => $this->translator->trans('booking.lname.label'),
            ))
            ->add('email', EmailType::class, array(
                'label' => $this->translator->trans('booking.email.label'),
            ))
            ->add('phone', TextType::class, array(
                'label' => $this->translator->trans('booking.phone.label'),
            ))
            ->add('fromDate', DateType::class, array(
                'widget' => 'single_text',
                'label' => $this->translator->trans('booking.fromDate.label'),
            ))
            ->add('toDate', DateType::class, array(
                'widget' => 'single_text',
                'label' => $this->translator->trans('booking.toDate.label'),
            ))
            ->add('room', ChoiceType::class, array(
                'choices' => array(
                    $this->translator->trans('booking.room.red') => 'red',
                    $this->translator->trans('booking.room.green') => 'green',
                    $this->translator->trans('booking.room.blue') => 'blue',
                ),
                'label' => $this->translator->trans('booking.room.label'),
            ))
            ->add('save', SubmitType::class)
        ;
    }

    /**
     * Set default form configurations.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Booking'
        ));
    }
}
