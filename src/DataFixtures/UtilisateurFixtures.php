<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager,PasswordEncoderInterface $passwordEncoder)
    {  for ($i=1; $i <=2 ; $i+1) { 
        $login = new Utilisateur();
        $login->setNom("Doudou Mohamet GAYE");
        $login->setLogin("dmg");
        $login->setEmail("doudoumohametgaye@gmail.com");
        $login->setTelephone(782257053);
        $login->setStatut("actif");
        $login->setRoles(["ROLE_SUPERADMIN"]);
        $login->setPassword("123");
        $login->setPhoto("https://pbs.twimg.com/media/DzuvaRsWwAIxSko.jpg");
        $manager->persist($login);
    }
       
        $manager->flush();
    }
}
