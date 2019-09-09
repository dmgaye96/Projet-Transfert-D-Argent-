<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/compte")
 *
 */
class CompteController extends AbstractController
{
   

    /**
     * @Route("/new", name="comptenew", methods={"GET","POST"})
     * 
     */
    public function new(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager ): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class,$compte);
        $data=$request->request->all();
        
        $form->submit($data);
        $compte->setSolde(1);
        $num = rand(1000000000, 9999999999);
        $sn = "SN";
        $number = $sn . $num;
        $compte->setNumerocompte($number);
        if($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compte);
            $entityManager->flush();
        
        return new Response('Le compte a été ajouté',Response::HTTP_CREATED);
    }
       
        return new Response('Vous devez renseigner les informations du compte ',Response::HTTP_CREATED );
    }


    /**
     * @Route("/addCompte", name="ajou_compte", methods={"POST","PUT"})
     *
     */
    public function addcompteuser (Request $request,  CompteRepository $comptes, UtilisateurRepository $users, EntityManagerInterface $entityManager)
    {
       
        $values =$request->request->all();
      
        $ut=$users->findOneBy(['login'=>$values['login']]);
        $c=$comptes->findById($values['compte']);

   

        if(!$ut ){
          return new Response("Ce username n'existe pas ",Response::HTTP_CREATED);
        }
     
          $ut->setCompte($c[0]);
     


            $entityManager->flush();
            $data = [
                'status14' => 200,
                'message14' => 'Le compte a bien été  bien ajoute'
            ];
            return new JsonResponse($data);
        
    }










    /**
     * @Route("/{id}", name="compte_show", methods={"GET"})
     */
    public function show(Compte $compte): Response
    {
        return $this->render('compte/show.html.twig', [
            'compte' => $compte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="compte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Compte $compte): Response
    {
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('compte_index');
        }

        return $this->render('compte/edit.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="compte_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Compte $compte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($compte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('compte_index');
    }
}
