<?php

namespace HDV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {


      parent::buildForm($builder, $options);
      $builder
        ->remove('username')
        ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
            'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'Nouveau mot de passe'),
            'second_options' => array('label' => 'Confirmer nouveau mot de passe'),
            'invalid_message' => 'fos_user.password.mismatch',
            'required'    => false,
        ))
    ;
  }

  public function getParent()
     {
         return 'FOS\UserBundle\Form\Type\ProfileFormType';

     }

     public function getBlockPrefix()
     {
         return 'app_user_profile';
     }

}
