<?php

namespace App\Form;

use App\Entity\Cancion;
use App\Entity\ConcursoCanciones;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcursoCancionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label' => 'Nombre del concurso'])
            ->add('canciones', EntityType::class, ['class' => Cancion::class, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
            }, "multiple" => true, 'expanded' => true, 'choice_label' => 'nombre', 'label' => false])
            ->add('fechaInicio', DateType::class, ['label' => 'Fecha de inicio', 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add('fechaFinal', DateType::class, ['label' => 'Fecha de final', 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add('send', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConcursoCanciones::class,
        ]);
    }
}
