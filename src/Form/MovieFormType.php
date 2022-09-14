<?php

namespace App\Form;

use App\Entity\Movie;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // we define the fields of the form for validation (,)
        $builder
            ->add('title', TextType::class, [
                'attr' => array(
                    'class' => 'bg-transparent black border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter the title'
                ),
                'label' => false,
                'required' => false
            ])
            ->add('releaseYear', IntegerType::class, [
                'attr' => array(
                    'class' => 'bg-transparent black mt-10 border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter the release year'
                ),
                'label' => false,
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'attr' => array(
                    'class' => 'bg-transparent black border-b-2 w-full h-60 text-6xl outline-none',
                    'placeholder' => 'Enter the description'
                ),
                'label' => false,
                'required' => false
            ])
            ->add('imagePath', FileType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => array(
                    'class' => 'py-10',
                ),
            ])
            /* ->add('imagePath', FileType::class, [
                'attr' => array(
                    'class' => 'py-10',
                ),
                'label' => false
            ])*/
            //->add('actors')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
