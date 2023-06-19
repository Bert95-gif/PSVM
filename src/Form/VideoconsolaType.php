<?php

namespace App\Form;

use App\Entity\Videoconsola;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class VideoconsolaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label' => 'Nombre*'])
            ->add('abreviatura', TextType::class, ['label' => 'Abreviatura*'])
            ->add('empresa', TextType::class, ['label' => 'Empresa*'])
            ->add('anioProduccion', IntegerType::class, ['label' => 'Año de lanzamiento*', 'constraints' => [new Positive()]])
            ->add('anioDescontinuacion', IntegerType::class, ['label' => 'Año de descontinuación', 'required' => false, 'constraints' => [new Positive()]])
            ->add('imagen', TextType::class, ['label' => 'Enlace de imagen*'])
            ->add('save', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Videoconsola::class,
        ]);
    }
}
