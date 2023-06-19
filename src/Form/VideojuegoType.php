<?php

namespace App\Form;

use App\Entity\Genero;
use App\Entity\Videoconsola;
use App\Entity\Videojuego;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class VideojuegoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, ['label' => 'Título'])
            ->add('calificacion', IntegerType::class, [
                'label' => 'Calificación por edades (Nota: Se mostrará en cada videojuego una imagen de la calificación según PEGI conforme el número que introduzcas. Las imágenes son de 3, 7, 12, 16 y 18, y si introduces algún valor superior a alguno de los 5 mostrados antes, se cambiará automáticamente al valor de calificación menor que él al introducir el videojuego.)', 'constraints' => [new Positive()],
                'attr' => [
                    'min' => 3,
                    'max' => 18
                ]
            ])
            ->add('anio', IntegerType::class, ['label' => 'Año de lanzamiento'])
            ->add('generos', EntityType::class, ['class' => Genero::class, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.tipo', 'ASC');
            }, "multiple" => true, 'expanded' => true, 'choice_label' => 'tipo', 'label' => false])
            ->add('consolas', EntityType::class, ['class' => Videoconsola::class, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
            }, "multiple" => true, 'expanded' => true, 'choice_label' => 'nombre', 'label' => false])
            ->add('imagen', TextType::class, ['label' => 'Enlace de imagen'])
            ->add('enlace', TextType::class, ['label' => 'Enlace de página'])
            ->add('send', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Videojuego::class,
        ]);
    }
}
