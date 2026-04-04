<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\BikeMaintenance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikeMaintenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bike', EntityType::class, [
                'class' => Bike::class,
                'choice_label' => 'nickname',
            ])
            ->add('date')
            ->add('mileage')
            ->add('hours')
            ->add('maintenance_type')
            ->add('description')
            ->add('cost')
            ->add('workshop')
            ->add('parts_used')
            ->add('next_service_date')
            ->add('next_service_km')
            ->add('next_service_hours')
            ->add('receipt_url')
            ->add('notes')
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
            'data_class' => BikeMaintenance::class,
        ]);
    }
}
