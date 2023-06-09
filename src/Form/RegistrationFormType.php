<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
            ->add('email',EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champs.',
                    ]),]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'votre mot de passe doit avoir au moins {{ limit }} charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nom',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez mettre votre nom.',
                    ]),]
            ])
            ->add('prenom',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez mettre votre prenom.',
                    ]),]
            ])
            ->add('birth',DateType::class,[
                'label'=>"Date de naissance",
                'widget'=>'single_text',
                'years'=>range(date('Y'),date('Y')-100)
            ])
            ->add('telephone',TelType::class,[
                    'attr'=>[
                        'placeholder'=>' +243 xx xxx xxxx'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez remplir ce champs.',
                        ]),]
                ]
            )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'=>"I agree with the terms and conditions",
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les termes.',
                    ]),
                ],
            ])
            ->add('Enregistrer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
