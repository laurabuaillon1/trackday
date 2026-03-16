<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo_url',FileType::class,[
                'attr'=>[
                    'placeholder'=> 'Cliquer pour ajouter une photo',
                ],
                'label'=>'Photo de la moto',
                'data_class'=>null,
                'required'=>false,
            ])
            ->add('nickname',TextType::class,[
                'attr' =>[
                    'placeholder' => 'Ex:Ma Pistarde,Gex#1'
                ],
                'label'=> 'Pseudo(Surnom)',
            ])
            ->add('brand', TextType::class,[
                'attr' =>[
                    'placeholder'=> 'Ex: Yamaha',
                ],
                'label'=> 'Marque',
            ])
            ->add('model',TextType::class,[
                'attr' =>[
                    'placeholder'=>'Ex: R1',
                ],
                'label'=> 'Modèle'
            ])
            ->add('year',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Ex: 2020',
                ],
                'label'=>'Année'
            ])
            ->add('displacement',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Ex: 1000',
                ],
                'label'=> 'Cylindrée(cc)'
            ])
            ->add('color',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Ex: Bleu',
                ],
                'label'=> 'Couleur'
            ])
            ->add('license_plate',TextType::class,[
                'attr'=>[
                    'placeholder'=>'AB-123-CD',
                ],
                'label'=> 'Plaque d\'immatriculation'
            ])
            ->add('purchase_date',DateType::class,[
                'attr'=>[
                    'placeholder'=> 'jj/mm/aaaa',
                ],
                'label'=> 'Date d\'achat'
            ])
            ->add('mileage',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'Ex:15000km',
                ],
                'label'=> 'Utilisation actuelle'

            ])
            ->add('hours',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'Ex:15000km',
                ],
                'label'=> 'Utilisation actuelle'

            ])
            ->add('usage_unit',ChoiceType::class,[
                'choices'=>[
                    'kilomètres'=>'km',
                    'heures'=>'hours',
                    ],
                    'attr'=>[
                    'class'=>'form-field__textarea',
                    
                ]
            ])
            ->add('last_service_date',DateType::class,[
                'attr'=> [
                    'placeholder'=>'jj/mm/aaaa',
                ],
                'label'=> 'Dernier entretien'
            ])
            ->add('next_service_km',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'Ex:15000km',
                ],
                'label'=> 'Utilisation actuelle'

            ])
            ->add('next_service_hours',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'Ex:15000km',
                ],
                'label'=> 'Utilisation actuelle'

            ])
            ->add('notes',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Modifications,accessoires...',
                    'class'=> 'form-field__textarea',
                ],
                'label'=>'Notes'
            ])
            // ->add('is_active',CheckboxType::class,[
            //     'label'=> "moto active",
            // ])
            // ->add('created_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updated_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bike::class,
        ]);
    }
}
