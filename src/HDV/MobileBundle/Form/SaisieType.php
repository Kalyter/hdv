<?php

namespace HDV\MobileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SaisieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('dossier',    TextType::class)
        ->add('description',    TextareaType::class)
        ->add('estb',    TextType::class)
        ->add('esth',    TextType::class)
        ->add('auteur',     ChoiceType::class, array(
          'choices' => array(
          'Me Goxe' => '1',
          'Me Belaïsch' => '2',
          'Pascale'   => '3',
          'Steve'   => '4',
          'François'   => '5')))
        ->add('famille', EntityType::class, array('class' => 'HDVVentesBundle:Famille',
                                   'choice_label' => 'name',
                                   'placeholder' => 'Selectionner une famille...'
                                  ))
        ->add('ordre',    TextType::class, array(
                          'required' => false))
        ->add('image',     PhotoType::class, array(
                          'required' => false))
        ->add('save',      SubmitType::class, array( 'attr' => array('class' => 'btn btn-primary btn-block'),
                            'label'             => 'Enregistrer'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HDV\MobileBundle\Entity\Saisie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_mobilebundle_saisie';
    }


}
