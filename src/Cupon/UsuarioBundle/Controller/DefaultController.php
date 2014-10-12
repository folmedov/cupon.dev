<?php

namespace Cupon\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Cupon\UsuarioBundle\Entity\Usuario;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioType;

class DefaultController extends Controller
{
    public function indexAction($name) {
        return $this->render('UsuarioBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function comprasAction() {
        $usuario_id = 2;
        
        $em = $this->getDoctrine()->getManager();
        
        $compras = $em->getRepository('UsuarioBundle:Usuario')
                ->findTodasLasCompras($usuario_id);
        
        return $this->render('UsuarioBundle:Default:compras.html.twig', array(
            'compras' => $compras
        ));
    }
    
    public function loginAction() {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        
        $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR,
                $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
            );
        
        return $this->render('UsuarioBundle:Default:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }
    
    public function cajaLoginAction() {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        
        $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR,
                $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
            );
        
//        $usuario = $this->get('security.context')->getToken()->getUser();
        
        return $this->render('UsuarioBundle:Default:cajaLogin.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
//            'usuario' => $usuario
        ));
    }
    
    public function registroAction() {
        $peticion = $this->getRequest();
        
        $usuario = new Usuario;
        $usuario->setPermiteEmail(true);
        $usuario->setFechaNacimiento(new \DateTime('today - 18 years'));

        $formulario = $this->createForm(new UsuarioType(), $usuario);
        
        // Formulario creado desde el mismo controlador!
//        $formulario = $this->createFormBuilder($usuario)
//                ->add('nombre')
//                ->add('apellidos')
//                ->add('direccion', 'text')
//                ->add('fechaNacimiento', 'date');
//        $formulario = $formulario->getForm();
        
        if ($peticion->getMethod() == 'POST') {
            $formulario->bind($peticion);
            
            if ($formulario->isValid()) {
//                $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
//                
//                $usuario->setSalt(md5(time()));
//                
//                $passwordCodificado = $encoder
//                        ->encodePassword($usuario->getPassword(), $usuario->getSalt());
//                
//                $usuario->setPassword($passwordCodificado);
//                
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($usuario);
//                $em->flush();
                
                $peticion->getSession()->setFlash(
                        'info', 
                        '¡Enhorabuena! Te has registrado correctamente en Cupon'
                    );
                
                $token = new UsernamePasswordToken(
                        $usuario->getUsername(),
                        $usuario->getPassword(),
                        'usuarios',
                        $usuario->getRoles()
                    );
                $this->container->get('security.context')->setToken($token);
                
                return $this->redirect($this->generateUrl(
                        'portada', 
                        array('ciudad' => $usuario->getCiudad()->getSlug())
                    ));
            }
        }
        
        return $this->render('UsuarioBundle:Default:registro.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }
    
    public function perfilAction() {
        $usuario = $this->get('security.context')->getToken()->getUser();
        
        $formulario = $this->createForm(new UsuarioType(), $usuario);
        
        $peticion = $this->getRequest();
        
        if ($peticion->getMethod() == 'POST') {
            $passwordOriginal = $formulario->getData()->getPassword();
            
            $formulario->bind($peticion);
            
            if ($formulario->isValid()) {
                if ($usuario->getPassword() == null) {
                    $usuario->setPassword($passwordOriginal);
                } else {
                    $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
                    
                    $passwordCodificado = $encoder->encodePassword(
                            $usuario->getPassword(),
                            $usuario->getSalt()
                        );
                    
                    $usuario->setPassword($passwordCodificado);
                }
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();
                
                $peticion->getSession()->setFlash(
                        'info', 
                        'Los datos de tu perfil se han actualizado correctamente'
                    );
                
                return $this->redirect($this->generateUrl('usuario_perfil'));
            }
        }
        
        return $this->render('UsuarioBundle:Default:perfil.html.twig', array(
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ));
    }
    
}