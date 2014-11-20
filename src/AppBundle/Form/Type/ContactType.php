<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', 'text')
            ->add('emailAddress', 'email')
            ->add('company')
            ->add('phoneNumber')
            ->add('subject', 'text')
            ->add('message', 'textarea', [
                'attr' => [
                    'rows' => 10,
                    'cols' => 50,
                ],
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }

    public function getName()
    {
        return 'contact';
    }
} 
