<?php

namespace Chiave\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticlesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new \DateTime('now');
        $builder
            ->add('title')
            ->add('shortContent')
            ->add('content')
            ->add('page')
            ->add('important')
            // ->add('publicationDate')
            // 
//<input type="text" value="2012-05-15 21:05" class="fdatetimepicker" data-date-format="yyyy-mm-dd hh:ii">
            ->add('publicationDate', 'datetime', array(
                    'widget'    => 'single_text',
                    'attr' => array(
                            'class' => 'fdatetimepicker row date collapse',
                            'data-date-format'  => 'yyyy-mm-dd hh:ii:ss',
                            'value' => $now->format('Y-m-d H:i:s')
                        )
                ))
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
            'data_class' => 'Chiave\CMSBundle\Entity\Articles'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'chiave_cmsbundle_articles';
    }
}
