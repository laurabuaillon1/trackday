<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name',TextType::class,[
                'label'=>'Nom',
                'attr'=> [
                    'placeholder'=>'Nom de famille ',
                ]
            ])
            ->add('first_name')
            ->add('email')
            // ->add('password')
            // ->add('created_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('last_login_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('account_status')
            // ->add('roles')
            // ->add('profile_picture')
            // ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
