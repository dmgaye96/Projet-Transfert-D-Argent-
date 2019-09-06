<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Form\DepotType;
use App\Entity\Compte;
use App\Repository\DepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\User\User;

/**
 * @Route("/api/depot")
 */
class DepotController extends AbstractController
{
    /**
     * @Route("/", name="depot_index", methods={"GET"})
     */
    public function index(DepotRepository $depotRepository): Response
    {
        return $this->render('depot/index.html.twig', [
            'depots' => $depotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="depot_new", methods={"GET","POST"})
     */
    public function new(Request $request,EntityManagerInterface $entityManager ): Response
    { 
        $depot = new Depot();
      //  $user =new User();
        $user=$this->getUser();
        $form = $this->createForm(DepotType::class,$depot);
        $data=$request->request->all();
        $depot->setDate(new \Datetime());
        $depot->setCaissier($user);
        $depot->getMontant();
       
        $form->submit($data);
        if($form->isSubmitted()){  
             $depot->getMontant();
            
            if ($depot->getMontant()>=75000) {
                $compte= $depot->getCompte();
                $compte->setSolde($compte->getSolde()+$depot->getMontant());
                $entityManager = $this->getDoctrine()->getManager();
                
                $entityManager->persist($compte);
                $entityManager->persist($depot);
                $entityManager->flush();
            return new Response('Le dépôt a été effectué',Response::HTTP_CREATED);
            }
            return new Response('Le montant du depot doit etre superieur ou egal a 75 000',Response::HTTP_CREATED);
         
        }

        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner le montant et le compte où doit être effectuer le dépot '
        ];
        return new Response($data, 500);

    }

    /**
     * @Route("/{id}", name="depot_show", methods={"GET"})
     */
    public function show(Depot $depot): Response
    {
        return $this->render('depot/show.html.twig', [
            'depot' => $depot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="depot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Depot $depot): Response
    {
        $form = $this->createForm(DepotType::class, $depot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('depot_index');
        }

        return $this->render('depot/edit.html.twig', [
            'depot' => $depot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="depot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Depot $depot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($depot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('depot_index');
    }
}
