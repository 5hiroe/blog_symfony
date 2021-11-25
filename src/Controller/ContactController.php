<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
    * @var ContactRepository
    */

    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/contact/{city}", name="contact")
     */
    public function index(Request $request, string $city = ""): Response
    {
        $customerName = $request->get('customerName');

        $form = $this->FormContactBase($request);

        return $this->renderForm('contact/index.html.twig', [
            'customerName' => $customerName,
            'city' => $city,
            'contact' => $this->contactRepository->findAll(),
            'form' => $form,

        ]);
    }

    /**
     * @Route("/contactId/{id}", name="contactId")
     */
    public function contactId(Request $request, string $id): Response
    {
        //$contact = $this->contactRepository->find($id);
        $form = $this->FormContactBase($request);

        return $this->renderForm('contact/index.html.twig', [
            'id' => $id,
            'contact' => $this->contactRepository->find($id),
            'form' => $form,
        ]);
    }

    private function FormContactBase(Request $request): \Symfony\Component\Form\FormInterface
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        dump($form->getViewData());

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form->getData());
            $entityManager->flush();

            dump("Envoyé en DB");
        }
        return $form;
    }
}
