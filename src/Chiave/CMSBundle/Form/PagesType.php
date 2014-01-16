<?php

namespace Chiave\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PagesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('shortDescription')
            ->add('staticContent')
            ->add('inMenu')
            ->add('slug')
            // ->add('image')
            ->add('position')
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
            'data_class' => 'Chiave\CMSBundle\Entity\Pages'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'chiave_cmsbundle_pages';
    }
}
