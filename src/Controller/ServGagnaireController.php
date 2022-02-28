<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
    public function login(Request $request,EntityManagerInterface $manager, SessionInterface $session): Response
    {
			//récupération des infos du formulaire.
			$login = $request->request->get("login");
			$password = $request->request->get("password");
            $reponse = $manager -> getRepository(Utilisateur :: class) -> findOneBy(['Login' => $login]);
            if($reponse==NULL){
                $message = "⛔ ATTENTION : Le login ne peut pas être nul ⛔";
                $session -> clear ();
            }
            else{
                $hash = $reponse -> getPassword();
                if (password_verify($password, $hash)){
                    $message = "✔️ Connexion réussie ✔️";
                    $session -> set('identifiant',$reponse->getId());
                }
                else{
                    $message = "⛔ ATTENTION : Mot de passe incorrect ⛔";  
                    $session -> clear ();
                }
            }

            return $this->render('serv_gagnaire/login.html.twig', [
              'login' => $login,
              'password' => $password,
              'message'=> $message,
        
        ]);
    }
    /**
     * @Route("/serv/newutil", name="serv_newutil")
     */
    public function newutil(): Response
    {
        return $this->render('serv_gagnaire/newutil.html.twig', [
            'controller_name' => 'ServGagnaireController',
        ]);
    }
    /**
     * @Route("/serv/inserutil", name="serv_inserutil")
     */
    public function inserutil(Request $request,EntityManagerInterface $manager): Response
    {
        $login = $request->request->get("login");
        $password = $request->request->get("password");
        $password =password_hash($password,PASSWORD_DEFAULT);
        $monUtilisateur = new Utilisateur ();
        $monUtilisateur -> setLogin($login);
        $monUtilisateur -> setPassword($password);
        $manager -> persist($monUtilisateur);
        $manager -> flush ();
        return $this->redirectToRoute ('serv_newutil');
    }
    /**
     * @Route("/serv/listeu", name="serv_listeu")
     */
    public function listeu(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    {
        $vs = $session -> get('identifiant');
        if($vs==NULL)
            return $this->redirectToRoute ('serv_gagnaire');
        else{
        $mesUtilisateurs=$manager->getRepository(Utilisateur::class)->findAll();
        return $this->render('serv_gagnaire/listeu.html.twig',['lst_utilisateurs' => $mesUtilisateurs]);
        }
    }

    /**
    * @Route("/supprimerUtilisateur/{id}",name="supprimer_Utilisateur")
    */
    public function supprimerUtilisateur(EntityManagerInterface $manager,Utilisateur $editutil): Response 
    {
    $manager->remove($editutil);
    $manager->flush();
    // Affiche de nouveau la liste des utilisateurs
    return $this->redirectToRoute ('serv_listeu');
    }
}
