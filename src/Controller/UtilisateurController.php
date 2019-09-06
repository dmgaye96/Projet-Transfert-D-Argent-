<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Envoi;
use App\Entity\Compte;
use App\Entity\Profile;
use App\Entity\Retrait;
use App\Form\EnvoiType;
use App\Form\CompteType;
use App\Form\RetraiType;
use App\Entity\Partenaire;
use App\Entity\Commissions;
use App\Entity\Utilisateur;
use App\Form\PartenaireType;
use Webmozart\Assert\Assert;
use App\Form\UtilisateurType;
use App\Repository\EnvoiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\Validator;
use Vich\UploaderBundle\Naming\UniqidNamer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $user= $this->getUser();
        $utilisateur->setAjouterpar($user);
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
     * @Route("/newuser", name="utilisateur_new", methods={"POST" ,"GET"})
     */
    public function newuser(Request $request,  EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator): Response
    {

        $utilisateur = new Utilisateur();
      //  $profile = new Profile();
        $file = $request->files->all()['imageName'];
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        
     // var_dump( $utilisateur->getProfile() );
        $repository = $this->getDoctrine()->getRepository(Profile::class);
        $a = $repository->findById($utilisateur->getProfile());
        foreach ($a as $id) {
         $num=$id->getId();
         //  var_dump($id->getId());
        }
  //  var_dump($a); die;
        if ( $num==3) {
           // var_dump($num);
            $utilisateur->setRoles(["ROLE_ADMINP"]);
        } else if ($num == 4) {
            $utilisateur->setRoles(["ROLE_USER"]);
        } 
        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $utilisateur->setImageFile($file);
        $utilisateur->setUpdatedAt(new \DateTime);
        $utilisateur->setStatut("actif");

        $idpartenaire = $this->getUser()->getPartenaire();
        $utilisateur->setPartenaire($idpartenaire);
        $entityManager = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        $utilisateur->setAjouterpar($user);
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
        $envoi->setGuichetier($user);  //insert  dans la table envoi l ID de l utlisateur qui est entrains d effectuer l operation
        $code = rand(11111111, 99999999);
        $numero = rand(11111111, 99999999);
        $envoi->setCodeenvoi($code . "0");
        $envoi->setNumero($numero . "0");
        $montant = $envoi->getMontant();
        $repository = $this->getDoctrine()->getRepository(Commissions::class);
        $commission = $repository->findAll();
        foreach ($commission as $commissions) {
            $commissions->getId(); //recuper tout les ID de la colonne
            $commissions->getBorninf(); 
            $commissions->getBornesup();
            $commissions->getCommissionttc();
            if ($montant >= $commissions->getBorninf() && $montant <= $commissions->getBornesup()) {
                $commissionttc = $commissions->getCommissionttc();
            }
        }
        $system = $commissionttc * 40 / 100; //commision du systeme
        $etat = $commissionttc * 30 / 100; //commission de l'etat
        $envoig = $commissionttc * 20 / 100; //commission du guichet d envoi
        $retait = $commissionttc * 10 / 100; //commission du guiche de retait
        $compt = $this->getUser()->getCompte(); //permet de connaitre le compte  avec le quelle l utilisateur du system travail
        if ($envoi->getMontant() >= $compt->getSolde()) {
            return new Response('le solde de votre compte est insuffisante ', Response::HTTP_CREATED);
        } else {
            $envoi->setCommissionguichetenvoie($envoig);
            $envoi->setCommissionguicheretrait($retait);
            $envoi->setCommissionsysteme($system);
            $envoi->setCommissionetat($etat);
            $compt->setSolde($compt->getSolde() + $system - $envoi->getMontant());  //met a jour le compte du partenaire
            $envoi->setTotal($envoi->getMontant() + $commissionttc); // calcule le motant totale a payer par le client
            $envoi->setCommitionttc($commissionttc);
        }
        $errors = $validator->validate($envoi);
        if (count($errors)) {
            return new Response($errors, 500, ['Content-Type' => 'application/json']);
        }
        $entityManager->persist($envoi);
        $entityManager->flush();
        /* //enerer le ficher pdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('default/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]); */

        return new Response('envoi effectif ', Response::HTTP_CREATED);
    }

    /**
     * @Route("/retrait",name="retrait",methods={"POST"})
     */

    public function retait(Request $request,  EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {

        $retrait = new Retrait();
        $form = $this->createForm(RetraiType::class, $retrait);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        $codeR = $retrait->getCode(); // recupere le code saisie par le guichetier
    
        $repository = $this->getDoctrine()->getRepository(Envoi::class);
        $envoi = $repository->findByCodeenvoi($codeR); //recher dans la table envoi le code saisie par l utilisateur
      
        if ($envoi != null) {
            $repository = $this->getDoctrine()->getRepository(Retrait::class);
            $coderetait = $repository->findByCode($codeR); //recherche  dans la table des retrait est ce que ce n est pas encore retirer 
           
            if ($coderetait != null) {
                return new Response('le code est deja retirer', Response::HTTP_CREATED);
            } else {
                foreach ($envoi as $envois) {
                   $comR=$envois->getCommissionguicheretrait();
                   $montanR=$envois->getMontant();
          
                   $total=$comR+ $montanR;  // calcul le totale a mise a jour a niveaux du compte
                   $compt = $this->getUser()->getCompte(); // permet de recuper le compt au quelle le guichethier est connecté
                   $compt->setSolde($compt->getSolde()+$total); //met a jour le compte de l utilisateur connecte a l instant T
                    $retrait->setDate(new \DateTime);
           
                    $user = $this->getUser(); //recuper l ID de l utilisateur connecter
                    $retrait->setGuichetier($user);
                 
                    $entityManager->persist($retrait);
                    $entityManager->flush();
                }
                return new Response('retrait  effectif ', Response::HTTP_CREATED);
            }
        } else {
            return new Response('le code  est invalide  veuiller  reassayer svp ', Response::HTTP_CREATED);
        }
    }

    /**
     * @Route("/remboursement" ,name="remboursement" ,methods={"POST"})
     */
    public function remboursement(Request $request,  EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {

        $retrait = new Retrait();
        $form = $this->createForm(RetraiType::class, $retrait);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        $codeR = $retrait->getCode(); // recupere le code saisie par le guichetier
        $repository = $this->getDoctrine()->getRepository(Envoi::class);
        $envoi = $repository->findByCodeenvoi($codeR); //recher dans la table envoi le code saisie par l utilisateur
        if ($envoi != null) {
            $repository = $this->getDoctrine()->getRepository(Retrait::class);
            $coderetait = $repository->findByCode($codeR); //recherche  dans la table des retrait est ce que ce n est pas encore retirer 
            if ($coderetait != null) {
                return new Response('le remboursemment est deja effectuer', Response::HTTP_CREATED);
            } else {
                foreach ($envoi as $envois) {
                   $comR=$envois->getCommissionguicheretrait();
                   $montanR=$envois->getMontant();
                   $total=$comR+ $montanR;  // calcul le totale a mise a jour a niveaux du compte
                   $compt = $this->getUser()->getCompte(); // permet de recuper le compt au quelle le guichethier est connecté
                   $compt->setSolde($compt->getSolde()+$total); //met a jour le compte de l utilisateur connecte a l instant T
                    $retrait->setDate(new \DateTime);
                    $user = $this->getUser(); //recuper l ID de l utilisateur connecter
                    $retrait->setGuichetier($user);
                    $entityManager->persist($retrait);
                    $entityManager->flush();
                }
                return new Response('remboursement  effectif ', Response::HTTP_CREATED);
            }
        } else {
            return new Response('le code  est invalide  veuiller  reassayer', Response::HTTP_CREATED);
        }
    }

    /**
     * @Route("/findcode" , name="findcodeer", methods={"POST" ,"GET"})
     */


     public function findcode(Request $request,EntityManagerInterface $entityManager, ValidatorInterface $validator , SerializerInterface $serializer){


        $retrait = new Retrait();
        $form = $this->createForm(RetraiType::class, $retrait);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        $codeR=  $retrait->getCode();
      //  var_dump($codeR); 
      //  $codeR =468684690;// $retrait->getCode(); // recupere le code saisie par le guichetier
        $repository = $this->getDoctrine()->getRepository(Envoi::class);
        $envoi = $repository->findByCodeenvoi($codeR); //recher dans la table envoi le code saisie par l utilisateur
    
    
        if ($envoi != null) {
            $repository = $this->getDoctrine()->getRepository(Retrait::class);
            $coderetait = $repository->findByCode($codeR); //recherche  dans la table des retrait est ce que ce n est pas encore retirer 
           
            if ($coderetait != null) {
                return new Response('le code est deja retirer', Response::HTTP_CREATED);
            } 
        } else {
            return new Response('le code  est invalide  veuiller  reassayer svp ', Response::HTTP_CREATED);
        }


        $data = $serializer->serialize($envoi, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]); 
     }
}
