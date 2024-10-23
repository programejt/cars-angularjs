<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarBrand;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('vin')
      ->add('registration_number')
      ->add('model')
      ->add('brand_id', EntityType::class, [
        'class' => CarBrand::class,
        'choice_label' => 'name',
        'label' => 'Brand',
        'placeholder' => 'Choose...'
      ])
      ->add('client_id', EntityType::class, [
        'class' => Client::class,
        'choice_label' => 'name',
        'label' => 'Client',
        'placeholder' => 'None',
        'required' => false
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Car::class,
    ]);
  }
}
