<?php

namespace HDV\VentesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('file', FileType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'HDV\VentesBundle\Entity\Image'
    ));
  }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_ventesbundle_image';
    }


}
