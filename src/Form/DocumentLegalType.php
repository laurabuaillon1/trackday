<?php

namespace App\Form;

use App\Entity\DocumentLegal;
use App\Entity\DocumentType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentLegalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('version', NumberType::class,[
                'attr' => [
                    'placeholder' => ' 1.0',
                ],
                'label' => 'Numéro de version',
            ])
            ->add('textContent', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Contenu des CGV,Mentions Légales,Politiques de confidentialités',
                    'class' => 'form-field__textarea',
                ],
                'label' => 'Texte du document',
            ])
            ->add('publicationDate', DateType::class, [
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa',
                ],
                'label' => 'Date de publication',
            ])
            ->add('isActive',CheckboxType::class, [
                'label' => 'Document actif',
                'required'=> false,
            ])
            ->add('documentType', EntityType::class, [
                'class' => DocumentType::class,
                'label' => 'Type de document',
                'choice_label' => 'label',
                'placeholder'=>'Choisissez le type du document',
                'attr' => [
                    'class' => 'form-field__dropdown',

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentLegal::class,
        ]);
    }
}
