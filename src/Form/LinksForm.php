<?php

namespace App\Form;

use App\Entity\Links;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinksForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('originalUrl', TextareaType::class, [
                'label' => 'Ваша ссылка: ',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-group']
            ])
            ->add('disposable', CheckboxType::class, [
                'label' => 'Одноразовая ссылка: ',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group-disposable']
            ])
            ->add('expirationDate', DateTimeType::class, [
                'label' => 'Дата истечения: ',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-date']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Links::class,
        ]);
    }
}
