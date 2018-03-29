<?php

namespace WH\MediaBundle\Form\Backend;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use WH\MediaBundle\Entity\File;

/**
 * Class FileType
 *
 * @package WH\MediaBundle\Form\Backend
 */
class FileType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'id',
                WHFinderType::class,
                [
                    'label'    => false,
                    'required' => false,
                ]
            );

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {

                if ($event->getData()) {
                    $data = $this->entityManager->getRepository('WHMediaBundle:File')->get(
                        'one',
                        [
                            'conditions' => [
                                'file.id' => $event->getData()->getId(),
                            ],
                        ]
                    );

                    $event->setData($data);

                }

            }
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