<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Logement;
use App\Entity\Type;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Logement1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('taille')
            ->add('description')
            ->add('couchage')
            ->add('isActive', HiddenType::class, ['data' => true])
            ->add('adresse')
            ->add('codePostal')
            ->add('Ville')
            ->add('pays')
            ->add('imagePath')
            ->add('name')
            ->add('equipementId', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'label',
                'multiple' => true,
            ])
            // ->add('userId', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ->add('typeId', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Logement::class,
        ]);
    }
}
