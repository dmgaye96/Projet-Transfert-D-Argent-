<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Partenaire;
use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Entity\Profile;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('password')
            ->add('nom')
            ->add('email')
            ->add('telephone')
            ->add('statut')
            ->add('imageFile',VichImageType::class)
            ->add('Partenaire',EntityType::class,[
                'class'=> Partenaire::class,
                'choice_label' =>'partenaire_id'
            ])
            ->add('Profile',EntityType::class,[
                'class'=> Profile::class,
                'choice_label' =>'profile_id'
            ])
            ->add('ajouterpar')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'csrf_protection'=>false
        ]);
    }
}
