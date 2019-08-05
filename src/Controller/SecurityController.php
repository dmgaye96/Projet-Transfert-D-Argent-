<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */

class SecurityController extends AbstractController
{
    /**
     *@Route("/register", name="register", methods={"POST"})
     */
  public function register(Request $request,EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
  {
    $profile = new Profile();
    $utilisateur = new Utilisateur();
    $form = $this->createForm(UtilisateurType::class, $utilisateur);
    $data=$request->request->all();
    $form->handleRequest($request);
    $form->submit($data);
    $file=$request->files->all()['imageName'];
   
    
    $repository = $this->getDoctrine()->getRepository(Profile::class);
   $a= $repository->findAll($profile->getLibelle());
    if ($utilisateur->getProfile()===$a[0] ){
        $role=["ROLE_SUPERADMIN"];
    } 
    else if
    ($utilisateur->getProfile()===$a[1] )  {
        $role=["ROLE_CAISSIER"] ;
    } else 
    {
        $role="";
    }

    $utilisateur->setRoles($role);
    $utilisateur->setImageFile($file);
    $utilisateur->setUpdatedAt(new \DateTime);
    $utilisateur->setStatut("Actif");
    $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
    $utilisateur->setPassword($hash);
    $entityManager = $this->getDoctrine()->getManager();
   
    $entityManager->persist($utilisateur);
    $entityManager->flush();
    return new Response('Le  Partenaire son Administrateur et compte a ete ajouter avec succes', Response::HTTP_CREATED);
    }
     

   /**
     * @Route("/login_check", name="login", methods={"POST"})
     * @return JsonResponse
     */
    public function login():JsonResponse

    {    
        $login =$this->getUser();
       
        return $this->json([
            'login' => $login->getUsername(),
            'roles' => $login->getRoles()
        ]);
        

    }
    
  }

