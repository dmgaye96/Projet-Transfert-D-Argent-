<?php

namespace App\Form;

use App\Entity\Envoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Commissions;

class EnvoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateenvoi')
            ->add('nomE')
            ->add('prenomE')
            ->add('telephoneE')
            ->add('AdresseE')
            ->add('montant')
            ->add('Numeropiece')
            ->add('datedelivrance')
            ->add('datedevalidite')
            ->add('nomB')
            ->add('prenomB')
            ->add('telephoneB')
            ->add('adresseB')
            //->add('total')
            ->add('commissionetat')
            ->add('commissionsysteme')
            ->add('commissionguichetenvoie')
            ->add('commissionguicheretrait')
            ->add('piece')
            ->add('paysenvoi')
            ->add('pays')
            ->add('commitionttc',EntityType::class ,[
                'class'=>Commissions::class,
                'choice_label'=>'commitionttc_id'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Envoi::class,
            'csrf_protection'=>false
        ]);
    }
}
