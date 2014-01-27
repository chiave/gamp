<?php

namespace Chiave\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Chiave\CMSBundle\Entity\Files;

class FilesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new \DateTime('now');
        $builder
            ->add('name')
            ->add('type', 'choice', array(
                'choices'   => Files::getTypesArray()
                )
            )
            ->add('description')
            ->add('visible')
            ->add('file')
            ->add('submit',
                'submit',
                array(
                    'label' => 'Wyślij'
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Chiave\CMSBundle\Entity\Files'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'chiave_cmsbundle_files';
    }
}
