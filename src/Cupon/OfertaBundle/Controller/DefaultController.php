<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name) {
        return $this->render('OfertaBundle:Default:index.html.twig', array('name' => $name));
    }

    public function ayudaAction() {
        return $this->render('OfertaBundle:Default:ayuda.html.twig');
    }
    
    public function portadaAction($ciudad) {
        $em = $this->getDoctrine()->getManager();
        
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOfertaDelDia($ciudad);
        
        if (!$oferta) {
            throw $this->createNotFoundException(
                    'No se ha encontrado la oferta del día'
            );
        }
        
        return $this->render('OfertaBundle:Default:portada.html.twig', array(
                    'oferta' => $oferta
        ));
    }
    
    public function ofertaAction($ciudad, $slug) {
        $em = $this->getDoctrine()->getManager();
        
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOferta($ciudad, $slug);
        
        if (!$oferta) {
            throw $this->createNotFoundException('No existe la oferta');
        }
        
        $relacionadas = $em->getRepository('OfertaBundle:Oferta')->findRelacionadas($ciudad);
        
        return $this->render('OfertaBundle:Default:detalle.html.twig', 
                             array(
                                 'oferta'=> $oferta, 
                                 'relacionadas' => $relacionadas
                             ));
    }

}
