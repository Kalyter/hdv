<?php

namespace HDV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class RegistrationFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
          ->remove('username')
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
               ));
    }

    public function getParent()
       {
           return 'FOS\UserBundle\Form\Type\RegistrationFormType';

       }

       public function getBlockPrefix()
       {
           return 'app_user_registration';
       }



}
