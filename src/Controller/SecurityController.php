<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Profile;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\DepotRepository;
use App\Repository\CompteRepository;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\MakerBundle\Validator;
use Vich\UploaderBundle\Naming\UniqidNamer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Tests\Stubs\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;


/**
 * @Route("/api")
 */

class SecurityController extends AbstractController
{


    /**
     *@Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator): Response
    {
        $profile = new Profile();
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        $file = $request->files->all()['imageName'];


        $repository = $this->getDoctrine()->getRepository(Profile::class);
        $a = $repository->findAll($profile->getLibelle());
        if ($utilisateur->getProfile() === $a[0]) {
            $utilisateur->setRoles(["ROLE_SUPERADMIN"]);
        } else if ($utilisateur->getProfile() === $a[1]) {

            $utilisateur->setRoles(["ROLE_CAISSIER"]);
        } else {
            $utilisateur->setRoles([]);
        }
        $utilisateur->setImageFile($file);
        $utilisateur->setUpdatedAt(new \DateTime);
        $utilisateur->setStatut("Actif");
        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $entityManager = $this->getDoctrine()->getManager();
        $errors = $validator->validate($utilisateur);
        if (count($errors)) {

            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }

        $entityManager->persist($utilisateur);
        $entityManager->flush();
        return new Response('Le  Partenaire son Administrateur et compte a ete ajouter avec succes', Response::HTTP_CREATED);
    }





    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;
    }
    

    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param JWTEncoderInterface $JWTEncoder
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request,JWTEncoderInterface $JWTEncoder)
    {
        $values = json_decode($request->getContent());        

        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $user = $repo-> findOneBy(['login' => $values->username]);
       
        

        // if(!$user ){
        //     $data = [
        //         'status2' => 400,
        //         'message2' => 'Username incorrect'
        //     ];
        //     return new JsonResponse($data);
        // }

        // $pass = $this->encoder->isPasswordValid($user, $values->password);
        // if(!$pass){
        //      $data = [
        //     'status2' => 400,
        //     'message2' => 'Mot de Pass incorrect'
        // ];
        // return new JsonResponse($data);
        // }

        if($user->getStatut()!=null && $user->getStatut()=="bloquer"){
            return $this->json([
                'message1' => 'Ce compte est bloqué'
            ]);
        }


        if($user->getStatut()!=null && $user->getPartenaire()!=null && $user->getPartenaire()->getStatut()=="bloquer"){
            return $this->json([
                'message1' => 'Le partenaire de cet utilisateur est bloqué'
            ]);
        }


        $token = $JWTEncoder->encode([
            'username' => $user->getUsername(),
            'exp' => time() + 86400 // 1 day expiration
        ]);
        return $this->json([
            'token' => $token
        ]);
    }

    /**
     *@Route("/liste/compte",name="listecompte", methods ={"GET"})
     */

    public function listercompte(CompteRepository $compteRepository, SerializerInterface $serializer)
    {

        $compte = $compteRepository->findAll();
        $data = $serializer->serialize($compte, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     *@Route("/liste/depot" ,name="listedepot",methods={"GET"})
     */

    public function listedepot(DepotRepository $depotRepository, SerializerInterface $serializer)
    {
        $depot = $depotRepository->findAll();
        $data = $serializer->serialize($depot, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     *@Route("/liste/partenaire/{id}", name="partenaire_detaill" ,methods={"GET"})
     */
    public function showpartenaire(PartenaireRepository $partenaireRepository, SerializerInterface $serializer, Partenaire $partenaire)
    {

        $partenaire = $partenaireRepository->find($partenaire->getId());
        $data = $serializer->serialize($partenaire, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     *@Route("/liste/utilisateur/{id}", name="utilisateurs_detaille", methods={"GET"})
     */

    public function showeuser(UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer, Utilisateur $utilisateur)
    {
        $user = $utilisateurRepository->find($utilisateur->getId());
        $data = $serializer->serialize($user, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     *@Route("/liste/compte/{id}",name="listecompte", methods ={"GET"})
     */

    public function showcopte(CompteRepository $compteRepository, SerializerInterface $serializer, Compte $compte)
    {

        $compte = $compteRepository->find($compte->getId());
        $data = $serializer->serialize($compte, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }


/**
 *@Route("/utilisateur/bloque/{id}", name="bloqueruser", methods ={"PUT"})
 */

public function bloquer($id)

{
$entityManager = $this->getDoctrine()->getManager();
$user =$entityManager->getRepository(Utilisateur::class)->find($id);
$stat =$user->getStatut();

if (  $stat === "actif" && $user->getRoles()===["ROLE_SUPERADMIN"] ) {
    return new Response('Vous ne pouver pas bloquer votre supperieur', Response::HTTP_CREATED);   
}

else if ($stat==="actif") {
 $user->setStatut("bloquer");

$entityManager->flush();

 return new Response('Utilisateur a etait bloquer', Response::HTTP_CREATED);
} 
else if($stat==="bloquer")
 {

    $user->setStatut("actif");
  
    $entityManager->flush();
    
     return new Response('Utilisateur a ete debloquer ', Response::HTTP_CREATED);
   }




}


}



