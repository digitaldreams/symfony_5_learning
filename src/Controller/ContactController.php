<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contact = new Contact();
        $contact->setName('Tuhin Bepari');
        $contact->setEmail('digitaldreams40@gmail.com');
        $contact->setPhoneNumber('+8801925000036');
        $entityManager->persist($contact);
        $entityManager->flush();
        return new Response('Contact saved successfully wit id ' . $contact->getId());
    }

    /**
     * @param int                               $id
     *
     * @param \App\Repository\ContactRepository $contactRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(int $id, ContactRepository $contactRepository)
    {
        $contact = $contactRepository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('No contact found for id: ' . $id);
        }

        return $this->render('contact/show.html.twig', [
            'name' => $contact->getName(),
            'email' => $contact->getEmail(),
            'phone_number' => $contact->getPhoneNumber(),
        ]);
    }

}