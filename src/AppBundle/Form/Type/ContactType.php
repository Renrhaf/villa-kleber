<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Form type to send contact emails.
 */
class ContactType extends AbstractType
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
        $builder->add('name', TextType::class, array(
            'label' => $this->translator->trans('contact.name.label'),
            'attr' => array('placeholder' => 'Jean Dupont'),
            'constraints' => array(
              new NotBlank(),
              new Length(array('min' => 2)),
            )
        ))
        ->add('email', EmailType::class, array(
            'label' => $this->translator->trans('contact.email.label'),
            'attr' => array('placeholder' => 'example@email.fr'),
            'constraints' => new NotBlank(),
        ))
        ->add('message', TextareaType::class, array(
            'label' => $this->translator->trans('contact.message.label'),
            'attr' => array(
              'rows' => 9,
              'placeholder' => $this->translator->trans('contact.message.placeholder')
            )
        ));

        $builder->add('submit', SubmitType::class, array(
          'label' => $this->translator->trans('contact.submit'),
        ));
    }
}