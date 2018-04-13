<?php

namespace HDV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class EditCoordType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('gender',     ChoiceType::class, array(
      'choices' => array(
      'Monsieur' => 'Monsieur',
      'Madame' => 'Madame',
      'Société'   => 'Société')))
    ->add('firstname',     TextType::class,array(
           'attr' => array('style' => 'width: 200px')
          ))
    ->add('lastname',     TextType::class,array(
           'attr' => array('style' => 'width: 200px')
          ))
    ->add('address',     TextType::class,array(
           'attr' => array('style' => 'width: 300px')
          ))
    ->add('address2',     TextType::class,array(
           'attr' => array('style' => 'width: 300px'),'required'    => false, 'empty_data'  => null
          ))
    ->add('zipCode',     TextType::class,array(
           'attr' => array('style' => 'width: 70px')
          ))
    ->add('city',     TextType::class,array(
           'attr' => array('style' => 'width: 200px')
          ))
    ->add('country',     CountryType::class,array(
      'preferred_choices' => array('FR') ))
    ->add('phone',     TextType::class,array(
           'attr' => array('style' => 'width: 150px')
          ))
    ->add('phone2',     TextType::class,array(
           'attr' => array('style' => 'width: 150px'),'required'    => false, 'empty_data'  => null
         ))
    ->add('send', SubmitType::class, array(
      'label'             => 'Envoyer'
  ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'HDV\UserBundle\Entity\User'
    ));
  }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_userbundle_edit_coord';
    }


}
