<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
        // Conditional fields.
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $booking = $event->getData();
            $form = $event->getForm();
            if (is_null($booking->getRoom())) {
                // Add room selector if not already set.
                $js_date_format = 'dd/MM/yyyy';
                $php_date_format = 'd/m/Y';
                $now = new \DateTime('now');

                $form->add('room', ChoiceType::class, array(
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
                ));
            }
        });

        // Add additional fields.
        $builder->add('fname', TextType::class, array(
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

    /**
     * Reorder form fields.
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        /** @var FormView[] $fields */
        $fields = [];
        foreach ($this->getFieldsOrder() as $field) {
            if ($view->offsetExists($field)) {
                $fields[$field] = $view->offsetGet($field);
                $view->offsetUnset($field);
            }
        }

        $view->children = $fields + $view->children;

        parent::finishView($view, $form, $options);
    }

    /**
     * Set fields order.
     *
     * @return array
     */
    function getFieldsOrder()
    {
        return [
            'room',
            'fromDate',
            'toDate',
            'fname',
            'lname',
            'email',
            'phone'
        ];
    }
}
