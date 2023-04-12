<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('uuid', TextType::class, [
//                'label' => 'Identifiant',
//                'label_attr' => [
//                    'class' => 'form-label'
//                ],
//                'attr' => [
//                    'class' => 'form-control',
//                    'autocomplete' => 'uuid'
//                ],
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'L\'identifiant est Obligatoire.'
//                    ])
//                ],
//                'required' => true,
//            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'email'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Email Obligatoire.'
                    ])
                ],
                'required' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Renseigner un mot de passe',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} charactères',
                            // max length allowed by Symfony for security reasons
                            'max' => 64,
                        ]),
                    ],
                    'label' => 'Mot de passe'
                ],
                'second_options' => [
                    'label' => 'Confirmer mot de passe'
                ],
                'required' => true,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'autocomplete' => 'new-password',
                    ],
                    'label_attr' => [
                        'class' => 'form-label'
                    ],
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Termes & Conditions',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Accepter les termes & conditions.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-check'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
