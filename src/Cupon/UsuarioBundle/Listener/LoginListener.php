<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\UsuarioBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

/**
 * Description of LoginListener
 *
 * @author francisco
 */
class LoginListener {

    //put your code here

    private $ciudad = null;
    
    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {
        $token = $event->getAuthenticationToken();
        $this->ciudad = $token->getUser()->getCiudad()->getSlug();
    }
    
    public function onKernelResponse(FilterResponseEvent $event) {
        if (null != $this->ciudad) {
            $portada = $this->router->generate('portada', array(
                'ciudad' => $this->ciudad
            ));
            $event->setResponse(new RedirectResponse($portada));
        }
    }

}
