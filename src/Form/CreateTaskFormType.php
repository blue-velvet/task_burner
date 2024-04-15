<?php

namespace App\Form;

use App\Entity\User;
use App\Model\CreateTaskRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;

class CreateTaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('createdBy', EntityType::class, [
                'required'        => true,
                'class'           => User::class,
                'invalid_message' => 'User not found',
                'constraints'     => [
                    new NotNull(message: 'User is required'),
                ],
            ])
            ->add('createdAt', DateTimeType::class, [
                'required'    => false,
                'input'       => 'datetime_immutable',
                'widget'      => 'single_text',
                'constraints' => [
                    new GreaterThanOrEqual('now', message: 'Date and time should be in future'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTaskRequest::class,
            'csrf_protection' => false
        ]);
    }
}