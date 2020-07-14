<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{

    public function index(ContactRepository $contactRepository)
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contact = new Contact();
        $contact->setName('Najmul Hossain');
        $contact->setEmail('najmul18@gmail.com');
        $contact->setPhoneNumber('+8801925000036');
        $entityManager->persist($contact);
        $entityManager->flush();
        return new Response('Contact saved successfully wit id ' . $contact->getId());
    }

    /**
     * @param \App\Entity\Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Contact $contact)
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

}