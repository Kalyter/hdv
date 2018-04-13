<?php

namespace HDV\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EstimateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
     public function buildForm(FormBuilderInterface $builder, array $options)
     {
         $builder
         ->add('mail', RepeatedType::class, array(
                      'type' => TextType::class,
                      'invalid_message' => 'Les emails de correspondent pas.',
                      'options' => array('attr' => array('class' => 'password-field')),
                      'required' => true,
                      'first_options'  => array('label' => 'Votre email :'),
                      'second_options' => array('label' => 'Confirmez votre email :'),
                  ))
        ->add('gender',     ChoiceType::class, array(
                      'choices' => array(
                      'Monsieur' => 'Monsieur',
                      'Madame' => 'Madame',
                       'Mademoiselle' => 'Mademoiselle',
                      'Société'   => 'Société')))
         ->add('nom')
         ->add('tel')
         ->add('message', TextareaType::class, array('attr' => array('rows' => '7')))
         ->add('images', Filetype::class, array('attr' => array(
                   'accept' => 'image/*',
                    'multiple' => 'multiple'
                )
            ))
         ->add('save',      SubmitType::class, array(
           'label'             => 'Envoyer'));
     }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
             'data_class' => 'HDV\MainBundle\Entity\Estimate'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_mainbundle_estimate';
    }


}
