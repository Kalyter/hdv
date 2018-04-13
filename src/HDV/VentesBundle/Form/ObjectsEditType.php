<?php

namespace HDV\VentesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ObjectsEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('adjuge',    TextType::class, array('required' => false, 'attr' => array('placeholder' => 'En euros...')))
        ->add('codeacq',   TextType::class, array('required' => false, 'attr' => array('placeholder' => 'Ivoire')));
    }

    public function getParent()
    {
      return ObjectsType::class;
    }


}
