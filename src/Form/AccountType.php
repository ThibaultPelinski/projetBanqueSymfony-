<?php

namespace App\Form;

use App\Entity\User; 
use App\Controller\AccountController; 
use App\Entity\Account;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('IBAN')
            ->add('balance')
            ->add('UserId', EntityType::class,["class"=>User::class,"choice_label"=>"email"]);
            // ->add('credits')
            // ->add('debits')
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
