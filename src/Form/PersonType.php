<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Group;
use App\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('firstName', TextType::class, [
            'label' => 'Prénom'
        ]);
        $builder->add('lastName', TextType::class, [
            'label' => 'Nom'
        ]);
        $builder->add('email', EmailType::class, [
            'label' => 'Email'
        ]);
        $builder->add('group', EntityType::class, [
            'label' => 'Groupe',
            'class' => Group::class,
            'choice_label' => 'name'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', Person::class);
    }
}