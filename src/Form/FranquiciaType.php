<?php

namespace App\Form;

use App\Entity\Franquicia;
use App\Entity\Pelicula;
use App\Entity\Serie;
use App\Entity\Videojuego;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranquiciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label' => 'Nombre'])
            ->add('peliculas', EntityType::class, ['class' => Pelicula::class, "multiple" => true, 'expanded' => true, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.titulo', 'ASC');
            }, 'choice_label' => 'titulo', 'label' => false])
            ->add('series', EntityType::class, ['class' => Serie::class, "multiple" => true, 'expanded' => true, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.titulo', 'ASC');
            }, 'choice_label' => 'titulo', 'label' => false])
            ->add('videojuegos', EntityType::class, ['class' => Videojuego::class, "multiple" => true, 'expanded' => true, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.titulo', 'ASC');
            }, 'choice_label' => 'titulo', 'label' => false])
            ->add('send', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Franquicia::class,
        ]);
    }
}
