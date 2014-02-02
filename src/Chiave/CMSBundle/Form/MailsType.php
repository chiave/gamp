<?php

namespace Chiave\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Chiave\CMSBundle\Entity\Mails;

class MailsType extends AbstractType
{
    protected $type;

    public function __construct ($type)
    {
        $this->type = $type;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $this->type;

        if ($type == "raport") {
            $builder->add('type', 'choice', array(
                'choices'   => Mails::getTypesArray(),
                'empty_value' => 'Wybierz powód kontaktu',
            ));
        }

        // if ($type == "contact") {
        // } elseif ($type == "raport") {
        // }

        $builder->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('phone')
            ->add('message', null, array(
                    'attr'    => array(
                        'cols' => 62,
                        'rows' => 8,
                    )
                )
            )
            ->add('submit',
                'submit',
                array(
                    'label' => 'Wyślij',
                    'attr'  => array(
                        'class'    => 'submit'
                    )
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
            'data_class' => 'Chiave\CMSBundle\Entity\Mails'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'chiave_cmsbundle_mails_raport';
    }
}
