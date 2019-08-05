<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Partenaire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;



/**
 * @Route("/api")
 */

class SecurityController extends AbstractController
{
    /**
     *@Route("/register", name="register", methods={"POST"})
     */
  public function register(Request $request,UserPasswordEncoderInterface $passwordEncoder,EntityManagerInterface $entityManager){

    $values=json_decode($request->getContent());

    if(isset($values->login)){
        $login = new Utilisateur();
        $login->setNom($values->nom);
        $login->setLogin($values->login);
        $login->setEmail($values->email);
        $login->setTelephone($values->telephone);
        $login->setRoles(["ROLE_SUPERADMIN"]);
        $login->setStatut("Actif");
        $login->setImageName("$values->image_name");
        $login->setUpdatedAt(new \DateTime);
        $login->setPassword($passwordEncoder->encodePassword($login,$values->password));
        $entityManager->persist($login);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => 'L\'utilisateur a été créé'
        ];

        return new JsonResponse($data, 201);
    }
    $data = [
        'status' => 500,
        'message' => 'Vous devez renseigner les clés login et password'
    ];
    return new JsonResponse($data, 500);

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

