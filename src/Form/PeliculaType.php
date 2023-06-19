<?php

namespace App\Form;

use App\Entity\Genero;
use App\Entity\Pelicula;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class PeliculaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, ['label' => 'Título'])
            ->add('duracion', IntegerType::class, ['label' => 'Duración por minutos', 'constraints' => [new Positive()]])
            ->add('anio', IntegerType::class, ['label' => 'Año de estreno', 'constraints' => [new Positive()]])
            ->add('generos', EntityType::class, ['class' => Genero::class, "multiple" => true, 'expanded' => true, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.tipo', 'ASC');
            }, 'choice_label' => 'tipo', 'label' => false])
            ->add('imagen', TextType::class, ['label' => 'Enlace de imagen'])
            ->add('enlace', TextType::class, ['label' => 'Enlace de página'])
            ->add('Send', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pelicula::class,
        ]);
    }
}
