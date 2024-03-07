<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,  [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le titre de la tache :",
                'label_attr' => ["class" => 'label_input'],
                'required' => true
            ])
            ->add('content', TextType::class, [
                'attr' => [
                    'class' => 'input'
                ],
                'label' => "Saisir le contenu de la tache :",
                'label_attr' => ["class" => 'label_input'],
                'required' => true
            ])
            ->add('expireDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'class' => 'input'
                ],
                'label' => 'Saisir la date de creation :',
                'label_attr' => ["class" => 'label_input'],
                'required' => true
            ])
            ->add('statut', CheckboxType::class,  [
                'label'    => 'Cette tache est finie ?',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
