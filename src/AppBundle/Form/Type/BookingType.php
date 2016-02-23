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
        $js_date_format = 'dd/MM/yyyy';
        $php_date_format = 'd/m/Y';
        $now = new \DateTime('now');

        $builder->add('room', ChoiceType::class, array(
            'choices' => array(
                $this->translator->trans('booking.room.red') => 'red',
                $this->translator->trans('booking.room.green') => 'green',
                $this->translator->trans('booking.room.blue') => 'blue',
            ),
            'choice_attr' => function($val, $key, $index) {
                return array('class' => 'room-' . $val);
            },
            'label' => $this->translator->trans('booking.room.label'),
            'expanded' => true,
        ))
        ->add('fromDate', DateType::class, array(
            'widget' => 'single_text',
            'format' => $js_date_format,
            'attr' => array(
                'class' => 'room-datepicker room-datepicker-from',
                'data-provide' => 'datepicker',
                'data-date-format' => strtolower($js_date_format),
                'placeholder' => $now->format($php_date_format)
            ),
            'label' => $this->translator->trans('booking.fromDate.label'),
        ))
        ->add('toDate', DateType::class, array(
            'widget' => 'single_text',
            'format' => $js_date_format,
            'attr' => array(
                'class' => 'room-datepicker room-datepicker-to',
                'data-provide' => 'datepicker',
                'data-date-format' => strtolower($js_date_format),
                'placeholder' => $now->modify('+2 days')->format($php_date_format)
            ),
            'label' => $this->translator->trans('booking.toDate.label'),
        ))
        ->add('fname', TextType::class, array(
            'label' => $this->translator->trans('booking.fname.label'),
            'attr' => array(
                'placeholder' => 'Jean'
            )
        ))
        ->add('lname', TextType::class, array(
            'label' => $this->translator->trans('booking.lname.label'),
            'attr' => array(
                'placeholder' => 'Dupont'
            )
        ))
        ->add('email', EmailType::class, array(
            'label' => $this->translator->trans('booking.email.label'),
            'attr' => array(
                'placeholder' => 'example@email.fr'
            )
        ))
        ->add('phone', TextType::class, array(
            'label' => $this->translator->trans('booking.phone.label'),
            'attr' => array(
                'placeholder' => '+33 1 12 34 56 78'
            )
        ));

        $builder->add('submit', SubmitType::class, array(
            'label' => $this->translator->trans('booking.submit'),
        ));
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
