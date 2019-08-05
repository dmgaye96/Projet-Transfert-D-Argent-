<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class UtilisateurFixtures extends Fixture

{
    public $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

        $login = new Utilisateur();
        $login->setNom("Doudou Mohamet GAYE");
        $login->setLogin("dmg");
        $mdp = "123";
        $login->setEmail("doudoumohametgaye@gmail.com");
        $login->setTelephone(782257053);
        $login->setStatut("actif");
        $login->setRoles(["ROLE_SUPERADMIN"]);
        $pass = $this->encoder->encodePassword($login, $mdp);
        $login->setUpdatedAt( new \DateTime());
        $login->setPassword($pass);
        $login->setImageName("https://pbs.twimg.com/media/DzuvaRsWwAIxSko.jpg");
    

        $manager->persist($login);
        $manager->flush();
        $login1 = new Utilisateur();
        $login1->setNom("Doudou Mohamet Gaye caissier");
        $login1->setLogin("dmgcaisier");
        $mdp = "123";
        $login1->setEmail("doudoumohametgaye@gmail.com");
        $login1->setTelephone(782257053);
        $login1->setStatut("actif");
        $login1->setRoles(["ROLE_CAISSIER"]);
        $pass = $this->encoder->encodePassword($login1, $mdp);
        $login1->setPassword($pass);
        

        $login1->setUpdatedAt( new \DateTime());
        $login1->setImageName("https://pbs.twimg.com/media/DzuvaRsWwAIxSko.jpg");
        $manager->persist($login1);
        $manager->flush();
    }
}
