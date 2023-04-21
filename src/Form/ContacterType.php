<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'placeholder'=>'votre nom'
                ]
            ])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=>'votre mail'
                ]
            ])
            ->add('sujet',TextType::class,[
                'attr'=>[
                    'placeholder'=>'votre sujet'
                ]
            ])
            ->add('message', TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'votre message ici'
                ]
            ])
            ->add('Contacter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
