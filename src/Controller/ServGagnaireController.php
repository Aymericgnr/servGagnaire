<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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
     * @Route("/serv/login", name="serv_login")
     */
    public function login(Request $request,EntityManagerInterface $manager): Response
    {
			//récupération des infos du formulaire.
			$login = $request->request->get("login");
			$password = $request->request->get("password");
            if ($login=="root" && $password=="toor")
                $message = "✔️ Login et mot de passe corrects ✔️";
            else
                $message = "⛔ ATTENTION : Login et mot de passe incorrects ⛔";  

            return $this->render('serv_gagnaire/login.html.twig', [
              'login' => $login,
              'password' => $password,
              'message'=> $message,
        
        ]);
    }
}
