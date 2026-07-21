<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEmprunt', null, [
                'widget' => 'single_text',
                'label' => "Date d'emprunt",
            ])
            ->add('dateRetourPrevue', null, [
                'widget' => 'single_text',
                'label' => 'Date de retour prévue',
            ])
            ->add('dateRetourEffective', null, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Date de retour effective',
            ])
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'titre',
                'label' => 'Livre',
                'placeholder' => '-- Choisissez un livre --',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Utilisateur',
                'placeholder' => '-- Choisissez un utilisateur --',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}