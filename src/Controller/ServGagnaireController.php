<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServGagnaireController extends AbstractController
{
    /**
     * @Route("/serv/gagnaire", name="serv_gagnaire")
     */
    public function index(): Response
    {
        return $this->render('serv_gagnaire/index.html.twig', [
            'controller_name' => 'ServGagnaireController',
        ]);
    }
    /**
     * @Route("/serv/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('serv_gagnaire/login.html.twig', [
            'controller_name' => 'ServGagnaireController',
        ]);
    }
}
