<?php

namespace App\Form;

use App\Entity\Bike;
use App\Entity\BikeMaintenance;
use BcMath\Number;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\BikeRepository;

class BikeMaintenanceType extends AbstractType
{

    private Security $security;

    // On injecte le service Security via le constructeur
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('bike', EntityType::class, [
                'class' => Bike::class,
                'choice_label' => 'nickname',
                'label' => 'Mes motos',
                'attr' => [
                    'class' => 'form-field__dropdown',

                ],
                // Ajout du QueryBuilder pour filtrer les motos
                'query_builder' => function (BikeRepository $er) use ($user) {
                    return $er->createQueryBuilder('b')
                        ->where('b.user = :user') 
                        ->setParameter('user', $user)
                        ->orderBy('b.nickname', 'ASC');
                },
            ])
            ->add('date', DateType::class, [
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa',
                ],
                'label' => 'Date de l\'entretien'
            ])
            ->add('mileage', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Ex:15000km',
                ],
                'label' => 'Utilisation actuelle'

            ])
            ->add('hours', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Ex:15000km',
                ],
                'label' => 'Utilisation actuelle',
                'required' => false,
            ])

            ->add('usage_unit', ChoiceType::class, [
                'choices' => [
                    'kilomètres' => 'km',
                    'heures' => 'hours',
                ],
                'attr' => [
                    'class' => 'form-field__dropdown--maintenance',

                ]
            ])
            ->add('maintenance_type', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Vidange,liquide de frein',
                ],
                'label' => 'Nom de l\'entretien'
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Vidange huile moteur + changement du filtre',
                ],
                'label' => 'Description'
            ])
            ->add('cost', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Ex: 10 €',
                ],
                'label' => 'Coût'
            ])
            ->add('workshop', ChoiceType::class, [
                'label' => 'Effectué par',
                'choices' => [
                    'Magasin spécialisé' => 'magasin',
                    'Moi-même' => 'moi-même',
                    'Un amis' => 'ami',
                ],
                'attr' => [
                    'class' => 'form-field__dropdown',

                ]
            ])
            ->add('parts_used', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: Rbf 660',
                ],
                'label' => 'Produits utilisés'
            ])
            ->add('next_service_date', DateType::class, [
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa',
                ],
                'label' => 'Prochain entretien'
            ])
            ->add('next_service_km', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Ex:15000km',
                ],
                'label' => 'Utilisation actuelle',

            ])
            ->add('next_service_hours', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Ex:15000km',
                ],
                'label' => 'Utilisation actuelle',
                'required' => false,

            ])
            ->add('receipt_url', FileType::class, [
                'mapped' => false,
                'label' => 'Joindre une facture',
                'required' => false,
                'constraints' => [
                    new Assert\File(
                        maxSize: '5M',
                        extensions: ['jpg', 'jpeg', 'png', 'webp', 'pdf'],
                        extensionsMessage: 'Veuillez uploader un fichier valide (jpg, jpeg, png, webp, pdf)',
                        maxSizeMessage: 'Le fichier ne doit pas dépasser 5MB.'
                    )
                ]
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
            'data_class' => BikeMaintenance::class,
        ]);
    }
}
