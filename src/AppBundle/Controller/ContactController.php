<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contact controller.
 * Manage pages dealing with contact.
 */
class ContactController extends Controller
{
    /**
     * Contact form page.
     */
    public function indexAction(Request $request)
    {
        // Prepare the contact form.
        $form = $this->createForm(ContactType::class, null, array(
            'action' => $this->generateUrl('contact'),
            'method' => 'POST',
        ));

        // Handle request data.
        $form->handleRequest($request);

        // Check if form is valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // Send the email.
            $ContactManager = $this->get('app.contact.manager');
            $data = $form->getData();
            $ContactManager->send($data);

            // Display the confirmation template.
            return $this->render('contact/confirm.html.twig', array(
              'contact' => $data
            ));
        }

        return $this->render('contact/index.html.twig', array(
            'contact' => $form->createView(),
        ));
    }
}
