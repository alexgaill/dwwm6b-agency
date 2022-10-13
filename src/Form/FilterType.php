<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->setMethod("GET")
            ->add('minSize', NumberType::class, [
                'label' => "Surface min.",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new PositiveOrZero(message:"Vous devez compléter ce champ avec un nombre supérieur à 0")
                ]
            ])
            ->add('maxSize', NumberType::class, [
                'label' => "Surface max.",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new PositiveOrZero(message:"Vous devez compléter ce champ avec un nombre supérieur à 0")
                ]
            ])
            ->add('minRooms', NumberType::class, [
                'label' => "Pièces min.",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new PositiveOrZero(message:"Vous devez compléter ce champ avec un nombre supérieur à 0")
                ]
            ])
            ->add('maxRooms', NumberType::class, [
                'label' => "Pièces max.",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new PositiveOrZero(message:"Vous devez compléter ce champ avec un nombre supérieur à 0")
                ]
            ])
            ->add('minPrice', NumberType::class, [
                'label' => "Prix min.",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new PositiveOrZero(message:"Vous devez compléter ce champ avec un nombre supérieur à 0")
                ]
            ])
            ->add('maxPrice', NumberType::class, [
                'label' => "Prix max.",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new PositiveOrZero(message:"Vous devez compléter ce champ avec un nombre supérieur à 0")
                ]
            ])
            ->add('transactionType', ChoiceType::class, [
                'label' => "Vendre/Louer",
                'choices' => [
                    'A louer' => false,
                    'A vendre' => true
                ],
                'mapped' => false,
                'required' => false
            ])
            ->add('propertyType', ChoiceType::class, [
                'label' => "Type de bien",
                'choices' => [
                    "Appartement" => 0,
                    "Maison" => 1,
                    "Villa" => 2,
                    "Parking" => 3,
                    "Cave" => 4
                ],
                'mapped' => false,
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Rechercher"
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
