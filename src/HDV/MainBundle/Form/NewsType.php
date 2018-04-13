<?php

namespace HDV\MainBundle\Form;

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

class NewsType extends AbstractType
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
          ->add('content', CKEditorType::class, array (
    'label'             => 'Contenu',
    'config_name'       => 'my_custom_config',
    'config' => array(
        'language'    => 'fr'
    ),
))
          ->add('published', CheckboxType::class, array(
            'label'             => 'Publié',
            'required' => false

          ))
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
             'data_class' => 'HDV\MainBundle\Entity\News'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hdv_mainbundle_news';
    }


}
