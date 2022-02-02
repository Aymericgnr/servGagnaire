<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function login(Request $request): Response
    {
			//récupération des infos du formulaire.
			$login = $request->request->get("Login");
			$password = $request->request->get("Password");
            $message = $request->request->get("message");
            if ($login=="root" && $password=="toor")
            $message = "login et mot de passe correct";
            else
                $message = "ATTENTION : login et mot de passe incorrect";       
        return $this->render('serv_gagnaire/login.html.twig', [
            'Login' => $login,
            'Password' => $password,
            'message'=> $message,
        
        ]);
    }
}
