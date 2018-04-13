<?php

namespace HDV\VentesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class OrdresType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type',     ChoiceType::class, array(
          'choices' => array(
          '' => '',
          'Téléphone' => 'Tel',
          'Ordre Fixe' => 'Ordre')))
        ->add('montant',     TextType::class,array(
              'required'    => false, 'empty_data'  => null
             ))
        ->add('save',      SubmitType::class, array(
          'label'             => 'Enregistrer'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HDV\VentesBundle\Entity\Ordres'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_ventesbundle_ordres';
    }


}
