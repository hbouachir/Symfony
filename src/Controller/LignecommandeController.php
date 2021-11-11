<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LignecommandeController extends AbstractController
{
    /**
     * @Route("/lignecommande", name="lignecommande")
     */
    public function index(): Response
    {
        return $this->render('lignecommandeFront.html.twig', [
            'controller_name' => 'LignecommandeController',
        ]);
    }
}
