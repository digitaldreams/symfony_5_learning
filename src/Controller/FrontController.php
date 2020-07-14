<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homePage(): Response
    {
        return $this->render('home-page.html.twig', [
            'message' => 'Good morning web Artisans from Dhaka!',
        ]);
    }
}