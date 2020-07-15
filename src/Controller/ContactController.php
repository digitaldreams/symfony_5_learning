<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @param \App\Repository\ContactRepository $contactRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function index(ContactRepository $contactRepository)
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findBy([
                'user' => $this->getUser(),
            ]),
        ]);
    }

    /**
     * @param \App\Entity\Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Contact $contact)
    {
        $this->denyAccessUnlessGranted('VIEW', $contact);

        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        return $this->render('contact/create.html.twig', [
            'contact' => new Contact(),
            'errors' => [],
        ]);
    }

    /**
     * @param \App\Entity\Contact $contact
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Contact $contact)
    {
        $this->denyAccessUnlessGranted('UPDATE', $contact);

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'errors' => [],
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @param \Symfony\Component\HttpFoundation\Request                 $request
     *
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse| \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, ValidatorInterface $validator)
    {
        $contact = new Contact();
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhoneNumber($request->get('phone_number'));
        $errors = $validator->validate($contact);

        if (count($errors) > 0) {
            return $this->render('contact/create.html.twig', [
                'errors' => $errors,
                'contact' => $contact,
            ]);
        }
        $contact->setUser($this->getUser());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contact);
        $entityManager->flush();

        $this->addFlash('message', 'Contact successfully created');

        return $this->redirectToRoute('show_contact', [
            'id' => $contact->getId(),
        ]);
    }

    /**
     * @param \App\Entity\Contact                                       $contact
     *
     * @param \Symfony\Component\HttpFoundation\Request                 $request
     *
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function update(Contact $contact, Request $request, ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('UPDATE', $contact);

        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setPhoneNumber($request->get('phone_number'));

        $errors = $validator->validate($contact);
        if (count($errors) > 0) {
            return $this->render('contact/edit.html.twig', [
                'errors' => $errors,
                'contact' => $contact,
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contact);
        $entityManager->flush();

        $this->addFlash('message', 'Contact successfully updated');

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
        $this->denyAccessUnlessGranted('DELETE', $contact);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();

        $this->addFlash('message', 'Contact successfully deleted');

        return $this->redirectToRoute('index_contact');
    }

}