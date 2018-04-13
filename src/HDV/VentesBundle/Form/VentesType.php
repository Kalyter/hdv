<?php

namespace HDV\VentesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use HDV\VentesBundle\Form\DataTransformer\DateTimeTransformer;

class VentesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('image',     ImageType::class, array(
'required' => false))
          ->add('date',      TextType::class, array(
'required' => true,
'attr' => [
    'class' => 'form-control input-inline datetimepicker',
    'data-provide' => 'datetimepicker',
    'html5' => false,
],
))
          ->add('title',    TextType::class)
          ->add('description', CKEditorType::class, array (
    'label'             => 'Description',
    'config_name'       => 'my_custom_config',
    'config' => array(
        'language'    => 'fr'
    ),
))
          ->add('conditions', CKEditorType::class, array (
    'label'             => 'Conditions de vente',
    'config_name'       => 'my_custom_config',
    'config' => array(
        'language'    => 'fr'
    ),
))
          ->add('catpublished', CheckboxType::class, array(
            'label'             => 'Publié',
            'required' => false

          ))
          ->add('liveurl',    TextType::class)
          ->add('save',      SubmitType::class, array(
            'label'             => 'Enregistrer'));

        $builder->get('date')
            ->addModelTransformer(new DateTimeTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
             'data_class' => 'HDV\VentesBundle\Entity\Ventes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_ventesbundle_ventes';
    }


}
