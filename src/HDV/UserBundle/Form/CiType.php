<?php

namespace HDV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CiType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('file', FileType::class)
    ->add('send', SubmitType::class, array(
      'label'             => 'Envoyer'
  ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'HDV\UserBundle\Entity\Ci'
    ));
  }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_userbundle_ci';
    }


}
