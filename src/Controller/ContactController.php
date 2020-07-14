<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{

    public function index(ContactRepository $contactRepository)
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        return $this->render('contact/create.html.twig', [
            'contact' => new Contact(),
        ]);
    }

    /**
     * @param \App\Entity\Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Contact $contact)
    {
        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request                 $request
     *
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function store(Request $request,ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contact = new Contact();
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhoneNumber($request->get('phone_number'));
        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->redirectToRoute('show_contact', [
            'id' => $contact->getId(),
        ]);
    }

    /**
     * @param \App\Entity\Contact                       $contact
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function update(Contact $contact, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhoneNumber($request->get('phone_number'));
        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->redirectToRoute('show_contact', [
            'id' => $contact->getId(),
        ]);
    }

    /**
     * @param \App\Entity\Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();
        return $this->redirectToRoute('index_contact');
    }

}