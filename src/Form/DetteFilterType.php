<?php

namespace App\Form;

use App\Dto\DetteFilter;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DetteFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut',ChoiceType::class,[
                'choices'=>[
                    'Tout'=>null,
                    'Solde'=>"Solde",
                    'Non Solde'=>"Non Solde"
                ]
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])

            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'surname',  
                'placeholder' => 'Sélectionner un client', 
                'required' => false,
            ])

            ->add('filtrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark'],
            ]);

           
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetteFilter::class, 
            'csrf_protection' => true,
        ]);
    }
}
