<?php

namespace App\Controller;

use App\Entity\Envoi;
use App\Entity\Compte;
use App\Entity\Profile;
use App\Form\EnvoiType;
use App\Form\CompteType;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\PartenaireType;
use Webmozart\Assert\Assert;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\Validator;
use Vich\UploaderBundle\Naming\UniqidNamer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api/user")
 */
class UtilisateurController extends AbstractController
{


    /**
     * @Route("/newadmin", name="admin_utilisateur_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $data = $request->request->all();
        $form->submit($data);
        $partenaire->setStatut("actif");
        $errors = $validator->validate($partenaire);
        if (count($errors)) {

            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }
        $entityManager->persist($partenaire);
        $entityManager->flush();
        //recuperation de l id du partenaire//
        $repository = $this->getDoctrine()->getRepository(Partenaire::class);
        $part = $repository->find($partenaire->getId());
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $data = $request->request->all();
        $form->submit($data);
        $compte->setSolde(1);
        $num = rand(1000000000, 9999999999);
        $sn = "SN";
        $number = $sn . $num;
        $compte->setNumerocompte($number);
        $compte->setPartenaire($part);
        $entityManager = $this->getDoctrine()->getManager();
        $errors = $validator->validate($compte);
        if (count($errors)) {

            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }
        $entityManager->persist($compte);
        $entityManager->flush();


        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        $form->submit($data);
        $file = $request->files->all()['imageName'];
        $utilisateur->setRoles(["ROLE_ADMINP"]);
        $utilisateur->setPartenaire($part);
        $utilisateur->setImageFile($file);
        $utilisateur->setUpdatedAt(new \DateTime);
        $utilisateur->setStatut("actif");
        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $entityManager = $this->getDoctrine()->getManager();
        $errors = $validator->validate($utilisateur);
        if (count($errors)) {

            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }
        $entityManager->persist($compte);
        $entityManager->persist($utilisateur);
        $entityManager->flush();
        return new Response('Le  Partenaire son Administrateur et compte a ete ajouter avec succes', Response::HTTP_CREATED);
    }

    /**
     * @Route("/newuser", name="utilisateur_new", methods={"POST"})
     */
    public function newuser(Request $request,  EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator): Response
    {

        $utilisateur = new Utilisateur();
        $profile = new Profile();
        $file = $request->files->all()['imageName'];
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);

        $repository = $this->getDoctrine()->getRepository(Profile::class);
        $a = $repository->findAll($profile->getId());

        if ($utilisateur->getProfile() == $a[2]) {
            $utilisateur->setRoles(["ROLE_ADMINP"]);
        } else if ($utilisateur->getProfile() == $a[3]) {
            $utilisateur->setRoles(["ROLE_USER"]);
        } else {
            $utilisateur->setRoles([]);
        }



        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $utilisateur->setImageFile($file);
        $utilisateur->setUpdatedAt(new \DateTime);
        $utilisateur->setStatut("actif");

        $idpartenaire = $this->getUser()->getPartenaire();
        $utilisateur->setPartenaire($idpartenaire);
        $entityManager = $this->getDoctrine()->getManager();

        $errors = $validator->validate($utilisateur);
        if (count($errors)) {

            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }
        $entityManager->persist($utilisateur);
        $entityManager->flush();
        return new Response('Utilisateur ajouter', Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="utilisateur_show", methods={"GET"})
     */
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('', [
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utilisateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Utilisateur $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $data = json_decode($request->getContent(), true);
        $form->handleRequest($request);
        $form->Submit($data);
        $this->getDoctrine()->getManager()->flush();
        return new Response('Modification effectif ', Response::HTTP_CREATED);
    }

    /**
     * @Route("/envoi",name="envoi",methods={"POST"})
     */
    public function envoi(Request $request,  EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $envoi = new Envoi();
        $form = $this->createForm(EnvoiType::class, $envoi);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        $envoi->setDateenvoi(new \DateTime());
        $user = $this->getUser(); //permet de recuperer l'id de l utilisateur qui est connecte
        $envoi->setGuichetier($user);
        $code = rand(11111111, 99999999);
        $numero = rand(11111111, 99999999);
        $envoi->setCodeenvoi($code . "0");
        $envoi->setNumero($numero . "0");
        $compt = $this->getUser()->getCompte(); //permet de connaitre le compte  avec le quelle l utilisateur du system travail
        $compt->setSolde($envoi->getMontant() + $compt->getSolde());
        $envoi->setTotal($envoi->getMontant() + $envoi->getCommitionttc()->getcommissionttc());
        $errors = $validator->validate($envoi);
        if (count($errors)) {
            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }
        $entityManager->persist($envoi);
        $entityManager->flush();
        return new Response('envoi effectif ', Response::HTTP_CREATED);
    }
}
