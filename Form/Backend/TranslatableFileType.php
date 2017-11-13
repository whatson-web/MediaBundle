<?php

namespace WH\MediaBundle\Form\Backend;

use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class TranslatableFileType
 *
 * @package WH\MediaBundle\Form\Backend
 */
class TranslatableFileType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'translatableUrl',
                ElFinderType::class,
                [
                    'label'    => 'Url :',
                    'required' => false,
                ]
            )
            ->add(
                'alt',
                TextType::class,
                [
                    'label'    => 'Texte alternatif (alt) :',
                    'required' => false,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'WH\MediaBundle\Entity\File',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wh_mediabundle_file';
    }

}
