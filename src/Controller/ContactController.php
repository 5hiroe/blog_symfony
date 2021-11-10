<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{



    /**
     * @Route("/contact/{city}", name="contact")
     */
    public function index(Request $request, string $city = ""): Response
    {
        $customerName = $request->get('customerName');

        return $this->render('contact/index.html.twig', [
            'customerName' => $customerName,
            'city' => $city,
        ]);
    }
}
