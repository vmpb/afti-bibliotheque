<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('endAt',DateTimeType::class, [
                'label' => 'Fini le'
            ])
            ->add('startAt',DateTimeType::class, [
                'label' => 'Commence le'
            ])
            ->add('article', EntityType::class, [
                'class' => Article::class
            ])
            ->add('Submit', SubmitType::class , [
                'label' => 'Réserver',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
