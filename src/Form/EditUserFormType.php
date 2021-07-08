<?php

namespace App\Form;

use Adamski\Symfony\PhoneNumberBundle\Form\PhoneNumberType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addsolde', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Nombre de Châtaignes'
            ])
            ->add('nom', TextType::class, [
                'required' => false
            ])
            ->add('telephone', PhoneNumberType::class, [
                'preferred' => 'FR',
                'mapped' => false,
                'required'  => false,
            ])
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'label' => 'Role',
                'choices'  => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
            ])
            ->add('date_fin', DateType::class, [
                'label' => 'Date d\'expiration du compte',
                'required' => false,
                'invalid_message' => 'La date est invalide',
            ])

            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
