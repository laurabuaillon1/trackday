<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname')
            ->add('brand')
            ->add('model')
            ->add('year')
            ->add('displacement')
            ->add('color')
            ->add('license_plate')
            ->add('purchase_date')
            ->add('mileage')
            ->add('hours')
            ->add('usage_unit')
            ->add('last_service_date')
            ->add('next_service_km')
            ->add('next_service_hours')
            ->add('photo_url')
            ->add('notes')
            ->add('is_active')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bike::class,
        ]);
    }
}
