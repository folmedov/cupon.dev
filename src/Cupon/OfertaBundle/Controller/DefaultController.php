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
    
    public function portadaAction() {
        $em = $this->getDoctrine()->getManager();

        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOneBy(array(
            'ciudad'=> 1,
            'fecha_publicacion' => new \DateTime('today')
        ));

        return $this->render(
                        'OfertaBundle:Default:portada.html.twig', 
                        array('oferta' => $oferta)
        );
    }

}
