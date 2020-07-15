<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register",methods="GET|HEAD")
     */
    public function form()
    {
        return $this->render('register/index.html.twig', [
            'errors' => [],
        ]);
    }

    /**
     * @Route("/register/store", name="register.store",methods="POST")
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface             $validator
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $userPassport
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $userPassport)
    {
        $user = new User();
        $user->setName($request->get('name'));
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->render('register/index.html.twig', [
                'errors' => $errors,
            ]);
        }
        $user->setPassword($userPassport->encodePassword($user, $request->get('password')));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('index_contact');
    }
}
