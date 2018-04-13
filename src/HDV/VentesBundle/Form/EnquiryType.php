<?php

namespace HDV\VentesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EnquiryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom')
        ->add('mail', RepeatedType::class, array(
                     'type' => TextType::class,
                     'invalid_message' => 'Les emails de correspondent pas.',
                     'options' => array('attr' => array('class' => 'password-field')),
                     'required' => true,
                     'first_options'  => array('label' => 'Votre email :'),
                     'second_options' => array('label' => 'Confirmez votre email :'),
                 ))
        ->add('tel')
        ->add('message', TextareaType::class, array(
    'attr' => array('rows' => '5')))
        ->add('save',      SubmitType::class, array(
          'label'             => 'Envoyer'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HDV\VentesBundle\Entity\Enquiry'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_ventesbundle_enquiry';
    }


}
