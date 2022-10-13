<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->setEntityLabelInSingular('Bien')
                ->setEntityLabelInPlural('Biens')
                ->setPaginatorPageSize(5)
                ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
        return [
            TextField::new('title'),
            TextEditorField::new('content')->hideOnIndex(),
            ChoiceField::new('transactionType')->setChoices(fn () => [
                "Location" => 0,
                "Vente" => 1
            ]),
            NumberField::new('size'),
            NumberField::new('floor'),
            TextField::new('address')->hideOnIndex(),
            TextField::new('postalCode'),
            TextField::new('city'),
            NumberField::new('price'),
            ChoiceField::new('propertyType')->setChoices(fn () => [
                "Appartement" => 0,
                "Maison" => 1,
                "Villa" => 2
            ])
            ];
        } else {

            return [
                IdField::new('id')->hideOnForm(),
                TextField::new('title'),
                TextEditorField::new('content')->hideOnIndex(),
                TextField::new('transactionType'),
                NumberField::new('size'),
                NumberField::new('floor'),
                TextField::new('address')->hideOnIndex(),
                TextField::new('postalCode'),
                TextField::new('city'),
                NumberField::new('price'),
                TextField::new('propertyType')
            ];
        }
        }
    }
    