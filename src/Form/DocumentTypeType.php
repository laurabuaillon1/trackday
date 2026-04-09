<?php

namespace App\Form;

use App\Entity\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class DocumentTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Diminutif',
                'attr' => [
                    'placeholder' => 'Ex: CGV, ML, PC',
                    'maxlength' => 50,
                ]
            ])
            ->add('label', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Mentions légales,Conditions générales de ventes,Politique de confidentialité',
                ],
                'label' => 'Titre du document',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentType::class,
        ]);
    }
}
