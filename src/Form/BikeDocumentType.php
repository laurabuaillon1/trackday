<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\BikeDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Validator\Constraints as Assert;

class BikeDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bike', EntityType::class, [
                'class' => Bike::class,
                'choice_label' => 'nickname',
                'label' => 'Mes motos',
                'attr' => [
                    'class' => 'form-field__dropdown',

                ]
            ])
            ->add('document_type', ChoiceType::class, [
                'label' => 'Type de document',
                'choices' => [
                    'Assurance'=>'Assurance',
                    'Facture d\'achat'=> 'Facture d\'achat',
                    'Facture de pièce'=> 'Facture de pièce',
                    'Garantie' => 'Garantie',
                ],
                'attr' => [
                    'class' => 'form-field__dropdown',

                ]
            ])
            ->add('document_name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Facture achat BMW 1200 GS',
                ],
                'label' => 'Nom du document'
            ])
            ->add('file_url', FileType::class, [
                'mapped' => false,
                'label' => 'Joindre une facture',
                'required' => false,
                'constraints' => [
                    new Assert\File(
                        maxSize: '5M',
                        extensions: ['jpg', 'jpeg', 'png', 'webp','pdf'],
                        extensionsMessage: 'Veuillez uploader un fichier valide (jpg, jpeg, png, webp, pdf)',
                        maxSizeMessage: 'Le fichier ne doit pas dépasser 5MB.'
                    )
                ]
            ])
            ->add('upload_date', DateType::class, [
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa',
                ],
                'label' => 'Date d\'ajout'
            ])
            ->add('expiry_date', DateType::class, [
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa',
                ],
                'label' => 'Date d\'ajout'
            ])
            ->add('amount', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Ex: 10 €',
                ],
                'label' => 'Coût'
            ])
            ->add('notes', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Modifications,accessoires...',
                    'class' => 'form-field__textarea',
                ],
                'label' => 'Notes',
                'required' => false,
            ])
            // ->add('created_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updated_at', null, [
            //     'widget' => 'single_text',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BikeDocument::class,
        ]);
    }
}
