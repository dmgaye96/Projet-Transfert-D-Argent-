<?php

namespace App\Form;

use App\Entity\Retrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetraiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('date')
            ->add('numeropiece')
            ->add('code')
            ->add('typedepiece');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Retrait::class,
            'csrf_protection' => false
        ]);
    }
}
