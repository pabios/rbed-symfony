<?php

namespace App\Form;

use App\Entity\Houssing;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\EventListener\HoussingFormSubscriber;
use App\EventListener\LoginVerifiedSubscriber;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HoussingType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       

        $builder
            ->add('name')
            ->add('price')
            ->add('status')
            ->add('description')
            ->add('slug')
            ->add('adresse')
            ->add('houssingType')
            ->add('postalCode', TextType::class, ["mapped" => false])
            ->addEventSubscriber(new HoussingFormSubscriber($this->em))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Houssing::class,
        ]);
    }
}
