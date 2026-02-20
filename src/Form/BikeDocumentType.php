<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\BikeDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikeDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('document_type')
            ->add('document_name')
            ->add('file_url')
            ->add('upload_date')
            ->add('expiry_date')
            ->add('amount')
            ->add('notes')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
            ->add('bike', EntityType::class, [
                'class' => Bike::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BikeDocument::class,
        ]);
    }
}
