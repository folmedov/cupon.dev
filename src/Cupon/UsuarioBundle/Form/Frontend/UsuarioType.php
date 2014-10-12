<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\UsuarioBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of UsuarioType
 *
 * @author francisco
 */
class UsuarioType extends AbstractType {

    public function getName() {
        return 'cupon_usuariobundle_usuariotype';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nombre')
                ->add('apellidos')
                ->add('email', 'email')
                ->add('password', 'repeated', array(
                        'type' => 'password',
                        'required' => true, 
                        'invalid_message' => 'Las dos contraseñas deben coincidir',
                        'first_options'  => array('label' => 'Contraseña'),
                        'second_options' => array('label' => 'Confirmar contraseña'),
                    ))
                ->add('direccion')
                ->add('permite_email', 'checkbox', array('required' => false))
                ->add('fecha_nacimiento', 'birthday')
                ->add('dni')
                ->add('numero_tarjeta')
                ->add('ciudad')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Cupon\UsuarioBundle\Entity\Usuario'
        ));
    }

}
