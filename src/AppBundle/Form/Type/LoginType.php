<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', 'text')
            ->add('_password', 'password')
        ;
    }

    public function getName()
    {
        return ''; // Doit être laissé vide pour le formulaire de connexion
    }
} 
