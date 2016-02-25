<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Admin controller.
 * Deals with admin pages.
 */
class AdminController extends Controller
{
    /**
     * Admin home.
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig', array());
    }
}
