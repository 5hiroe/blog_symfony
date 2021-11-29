<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function index(Request $request, SessionInterface $session, string $city = ""): Response
    {
        $customerName = $request->get('customerName');
        $typefav = $session->get('typefav');

        $form = $this->FormContactBase($request);

        return $this->renderForm('contact/index.html.twig', [
            'customerName' => $customerName,
            'city' => $city,
            'contact' => $this->contactRepository->findAll(),
            'form' => $form,
            'typefav' => $typefav

        ]);
    }
    /**
     * @Route("/")
     */
    public function indexHome(Request $request, SessionInterface $session): Response
    {
        $customerName = $request->get('customerName');
        $typefav = $session->get('typefav');

        if (empty($customerName) && !isset($customerName))
        {
            $customerName = " ";
        }

        return $this->renderForm('contact/index.html.twig', [
            'customerName' => $customerName,
            'typefav' => $typefav

        ]);
    }

    /**
     * @Route("/contactId/{id}", name="contactId")
     */
    public function contactId(Request $request, string $id, SessionInterface $session): Response
    {
        //$contact = $this->contactRepository->find($id);
        $form = $this->FormContactBase($request);
        $typefav = $session->get('typefav');


        return $this->renderForm('contact/index.html.twig', [
            'id' => $id,
            'contact' => $this->contactRepository->find($id),
            'form' => $form,
            'typefav' => $typefav
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
