<?php

namespace Chiave\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

use Chiave\CMSBundle\Entity\Pages;

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
            ->add('type', 'choice', array(
                'choices'   => Pages::getTypesArray()
                ))
            ->add('shortDescription')
            ->add('staticContent')
            ->add('slug')
            ->add('inMenu')
            ->add('menuName')
            ->add('position')
            ->add('icon', 'entity', array(
                    'class' => 'ChiaveCMSBundle:Files',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->where('f.type = 5') //5 == TYPE_ICON
                            ->orderBy('f.name', 'ASC');
                    },
                )
            )
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
