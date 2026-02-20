<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name')
            ->add('first_name')
            ->add('email')
            ->add('email_verified')
            ->add('password')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('last_login_at', null, [
                'widget' => 'single_text',
            ])
            ->add('account_status')
            ->add('role')
            ->add('profile_picture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
