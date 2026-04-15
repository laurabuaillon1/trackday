<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profile_picture', FileType::class, [
                'label' => 'Photo de profil',
                'data_class' => null,
                'required' => false,
                'constraints' => [
                    new Assert\File(
                        maxSize: '5M',
                        extensions: ['jpg', 'jpeg', 'png', 'webp'],
                        extensionsMessage: 'Veuillez uploader une image valide (jpg, jpeg, png, webp)',
                    )
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ],

            ])
            ->add('first_name', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email'
                ],
            ])
            // ->add('email_verified', EmailType::class,[
            //     'label'=> 'Email',
            //     'attr'=> [
            //         'placeholder'=> 'Confirmer votre adresse mail'
            //         ],
            // ])
            ->add('password', PasswordType::class,[
                'label'=>'Mot de passe',
                'attr'=> [
                    'placeholder'=> 'Mot de passe'
                    ],
            ])
            // ->add('created_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('last_login_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('account_status')
            ->add('roles', ChoiceType::class, [
                'mapped'=>false,
                'label' => 'Role',
                'placeholder' => 'Choisissez le role de l\'utilisateur',
                'choices' => [
                    'Admin' => 'Admin',
                    'User' => 'User',
                ],
                'multiple' => false, 
                'expanded' => false,
                'attr' => [
                    'class' => 'form-field__dropdown',

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
