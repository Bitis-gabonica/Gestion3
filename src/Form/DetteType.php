<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Dette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('montantVerse')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('statut',ChoiceType::class,[
                'choices'=>[
                    'Solde'=>'Solde',
                    'Non Solde'=>'Non Solde',
                ]
            ])
            ->add('enregister', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dette::class,
        ]);
    }

}
