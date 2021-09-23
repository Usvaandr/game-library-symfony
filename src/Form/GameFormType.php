<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameFormType extends AbstractType
{
    /**
     * @var PublisherRepository
     */
    private $publisherRepository;

    public function __construct(PublisherRepository $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 20
                        ])
                    ]
                ]
            )
            ->add('year', IntegerType::class,
                [
                'constraints' =>
                    [
                    new NotBlank(),
                    new Length(4),
                    ]
                ]
            )
            ->add('publisher', EntityType::class,
                [
                'placeholder' => 'Choose the publisher',
                'class' => Publisher::class,
                'choice_label' => 'name',
                'choices' => $this->publisherRepository
                    -> findByIsDeleted(false)
                ]
            )
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'game_item'
        ]);
    }
}
