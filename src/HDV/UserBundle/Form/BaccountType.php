<?php

namespace HDV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BaccountType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name', TextType::class, array(
        'label'             => 'Nom de votre banque',
        'required' => true,
         'attr' => array('value' => ''),
    ))
			->add('address', TextareaType::class, array(
        'label'             => 'Adresse de votre banque',
        'required' => true,
         'data' => '',
    ))
			->add('bic', TextType::class, array(
        'label'             => 'Code BIC',
        'required' => true,
         'attr' => array('value' => ''),
    ))
			->add('iban', TextType::class, array(
        'label'             => 'Code IBAN',
        'required' => true,
         'attr' => array('value' => ''),
    ))
			->add('save',      SubmitType::class, array(
        'label'             => 'Enregistrer'
    ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'HDV\UserBundle\Entity\Baccount'
    ));
  }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_userbundle_baccount';
    }


}
