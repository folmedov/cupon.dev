<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\OfertaBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Description of RequestListener
 *
 * @author francisco
 */
class RequestListener {
    
    public function onKernelRequest(GetResponseEvent $event) {
        $event->getRequest()->setFormat('pdf', 'application/pdf');
    }

}
