<?php

namespace HDV\VentesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ObjectsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('codedossier',    TextType::class, array('required' => false, 'attr' => array('class' => 'dossier',
                                                                       'style' => 'width:120px;display:inline;')))
        ->add('ordre',    TextType::class, array(
          'required' => false,
        ))
        ->add('ordrebis',    TextType::class, array(
          'required' => false,
        ))
        ->add('description',    TextareaType::class, array('attr' => array('style' => 'height:80px;',
                                                                       'placeholder' => 'Description...')))
        ->add('estimbasse',    TextType::class, array('required' => false, 'attr' => array('placeholder' => 'En euros...')))
        ->add('estimhaute',    TextType::class, array('required' => false, 'attr' => array('placeholder' => 'En euros...')))
        ->add('famille', EntityType::class, array('class' => 'HDVVentesBundle:Famille',
                                   'choice_label' => 'name',
                                   'placeholder' => 'Selectionner une famille...'
                                  ))
        ->add('save',      SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HDV\VentesBundle\Entity\Objects'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_ventesbundle_objects';
    }


}
