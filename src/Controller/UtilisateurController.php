<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\PartenaireType;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
         $data=$request->request->all();
        $form->submit($data);
        $entityManager->persist($partenaire);
        $entityManager->flush();
        //recuperation de l id du partenaire//
        $repository = $this->getDoctrine()->getRepository(Partenaire::class);
        $part = $repository->find($partenaire->getId());
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $data=$request->request->all();
        $form->submit($data);
        $compte->setSolde(1);
        $num = rand(1000000000, 9999999999);
        $sn = "SN";
        $number = $sn . $num;
        $compte->setNumerocompte($number);
        $compte->setPartenaire($part);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compte);
        $entityManager->flush(); 


        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        $form->submit($data);
        $file=$request->files->all()['imageName'];
        $utilisateur->setRoles(["ROLE_ADMINP"]);
        $utilisateur->setPartenaire($part);
        $utilisateur->setImageFile($file);
        $utilisateur->setUpdatedAt(new \DateTime);
        $utilisateur->setStatut("Actif");
        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compte);
        $entityManager->persist($utilisateur);
        $entityManager->flush();
        return new Response('Le  Partenaire son Administrateur et compte a ete ajouter avec succes', Response::HTTP_CREATED);
    }

    /**
     * @Route("/newuser", name="utilisateur_new", methods={"POST"})
     */
    public function newuser(Request $request,  EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {

        $utilisateur = new Utilisateur();
        $file=$request->files->all()['imageName'];
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $data=$request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        $utilisateur->setRoles(["ROLE_USER"]);
        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $utilisateur->setImageFile($file);
        $utilisateur->setUpdatedAt(new \DateTime);
        $utilisateur->setStatut("Actif");
        $entityManager = $this->getDoctrine()->getManager();
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

   
}
