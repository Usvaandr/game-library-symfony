<?php

namespace App\Form;

use App\Entity\Publisher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PublisherFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 20
                    ])
                ]
            ])
            ->add('value', MoneyType::class, [
                'currency' => 'USD',
                'label' => "Net Worth in billions",
                'scale' => 3,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('country', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Country([
                        'alpha3' => true,
                        'message' => 'Three-letter country code expected.'
                    ])
                ]
            ])
            ->add('year', DateType::class, [
                "widget" => 'single_text',
                "format" => 'yyyy',
                'html5' => false
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publisher::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'publisher_item'
        ]);
    }
}
