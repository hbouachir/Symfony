<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Payment;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
        ->add('numeroCompte')
        
        ->add('dateExpiration')
        ->add('civilite')
        ->add('Personne',EntityType::class,
          ['class'=>Personne::class,
              'choice_label'=>'nom'])
             
         
              
              ->add('Ajouter',SubmitType::class)
            ;
      
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}