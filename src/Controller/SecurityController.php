<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\Validator;

use Vich\UploaderBundle\Naming\UniqidNamer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UtilisateurRepository;
use App\Repository\CompteRepository;
use App\Repository\DepotRepository;

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

        /* $utilisateur->setRoles($role); */
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


    /**
     * @Route("/login_check", name="login", methods={"POST"})
     * @return JsonResponse
     */

    public function login(Request $request, EntityManagerInterface $entityManager)

    {

        $utilisateur = new Utilisateur();
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $a = $repository->findAll($utilisateur->getStatut());
        var_dump($a);
        $login = $this->getUser();

        return $this->json([
            'login' => $login->getUsername(),
            'roles' => $login->getRoles()
        ]);
    }


    /**
     * @Route("/liste/partenaire", name="liste_partenaire" ,methods={"GET"})
     */
    public function listerpartenaire(PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
        $partenaire = $partenaireRepository->findAll();
        $data = $serializer->serialize($partenaire, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }


    /**
     *@Route("/liste/utilisateur", name="listedesutilisateurs", methods={"GET"})
     */
        
    public function listeuser(UtilisateurRepository $utilisateurRepository,SerializerInterface $serializer)
    {  
       $user = $utilisateurRepository->findAll();
       $data = $serializer->serialize($user, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);

    }
 
/**
 *@Route("/liste/compte",name="listecompte", methods ={"GET"})
 */
 
 public function listercompte(CompteRepository $compteRepository, SerializerInterface $serializer) {

    $compte= $compteRepository->findAll();
    $data =$serializer->serialize( $compte , 'json');
    return new Response($data, 200, [
        'Content-Type' => 'application/json'
    ]);

 }

 /**
  *@Route("/liste/depot" ,name="listedepot",methods={"GET"})
  */

  public function listedepot(DepotRepository $depotRepository,SerializerInterface $serializer)
  {
      $depot=$depotRepository->findAll();
      $data=$serializer->serialize($depot,'json');
      return new Response($data,200,[
          'Content-Type' =>'application/json'
      ]);
  }

}
