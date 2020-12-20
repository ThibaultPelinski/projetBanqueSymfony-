<?php

namespace App\Form;
use App\Entity\User; 
use App\Entity\Target;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Transactions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('date')
            ->add('target', EntityType::class,["class"=>Target::class,"choice_label"=>"name"])
            ->add('user', EntityType::class,["class"=>User::class,"choice_label"=>"email"]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transactions::class,
        ]);
    }
}
