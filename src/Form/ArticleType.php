<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Translation\t;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[
                'required'=>true
            ])
            ->add('teaser',TextType::class,[
                'required'=>true
            ])
            ->add('corps',TextareaType::class,[
                'required'=>true
            ])
            ->add('type',EntityType::class,[
                'class'=>Type::class,
                'required'=>true
            ])
            ->add('categorie',EntityType::class,[
                'class'=>Categorie::class,
                'required'=>true
            ])
            ->add('imageEntete',EntityType::class,[
                'class'=>Image::class,
                'required'=>true
            ])
            ->add('imageCorps',EntityType::class,[
                'class'=>Image::class
            ])
            ->add('ecritPar',TextType::class,[
                'required'=>true
            ])
            ->add('dateAffihcer', DateType::class,[
                'required'=>true,
                'widget'=>'single_text',
                'format'=>'yyyy-MM-dd'
            ])
            ->add('section', ChoiceType::class,[
                'required'=>true,
                'choices'=>[
                    'Select..'=>'',
                    'Entête'=>'Entete',
                    'A la une'=>'A la une',
                    'tendances'=>'tendances',
                    'breaking news'=>'breaking'
                ]
            ])
            ->add('statut')
            ->add('Ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
