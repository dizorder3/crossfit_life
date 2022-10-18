<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
              'attr' => [
                'class' => 'form-control',
              ],
              'constraints' => [
                new NotBlank([
                  'message' => 'Veuillez entrer un mot de passe',
                ]),
                new Length([
                  'min' => 6,
                  'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                  'max' => 4096,
                ]),
              ],
              'label' => 'Entrez un nouveau mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}