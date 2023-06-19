<?php

namespace App\Form;

use App\Entity\Cancion;
use App\Entity\GeneroMusical;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label' => 'Título'])
            ->add('anio', IntegerType::class, ['label' => 'Año de grabación'])
            ->add('duracion', IntegerType::class, ['label' => 'Duración en segundos'])
            ->add('interprete', TextType::class, ['label' => 'Intérprete/s'])
            ->add('generos', EntityType::class, ['class' => GeneroMusical::class, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.tipo', 'ASC');
            }, "multiple" => true, 'expanded' => true, 'choice_label' => 'tipo', 'label' => false])
            ->add('send', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cancion::class,
        ]);
    }
}
