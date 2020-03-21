<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, [
                'label' => 'Pseudonyme',
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'max' => 60,
                        'minMessage' => 'Votre pseudo doit avoir au moins 2 caractères',
                        'maxMessage' => 'Votre pseudo doit avoir maximum 60 caractères',

                    ]),
                    new Assert\NotNull(),
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),
                ]
            ])
            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne correspondent pas, veuillez réessayer',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins 8 caractères',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*\d)(?=.*[A-Z])(?=.*[@#$%])(?!.*(.)\1{2}).*[a-z]/m',
                        'message' => 'Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole.'
                    ])              
                ]
            ])
            ->add('firstName',TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'max' => 60,
                        'minMessage' => 'Votre nom doit avoir au moins 2 caractères',
                        'maxMessage' => 'Votre nom doit avoir maximum 60 caractères',

                    ]),
                    new Assert\NotNull(),
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Votre nom ne peut pas contenir de chiffre',
                    ]),
                ]

            ])
            ->add('lastName',TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'max' => 60,
                        'minMessage' => 'Votre prénom doit avoir au moins 2 caractères',
                        'maxMessage' => 'Votre prénom doit avoir maximum 60 caractères',

                    ]),
                    new Assert\NotNull(),
                    new Assert\NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Votre prénom ne peut pas contenir de chiffre',
                    ]),
                ]
            ])
            ->add('Submit',SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'col-md-12 btn btn-block btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
