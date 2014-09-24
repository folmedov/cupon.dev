<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of OfertaRepositoy
 *
 * @author francisco
 */
class OfertaRepository extends EntityRepository{
    //put your code here
    
    public function findOfertaDelDia($ciudad) {
        $fechaPublicacion = new \DateTime('today - 1 seconds');
        
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   o, c, t '
                . 'FROM     OfertaBundle:Oferta o '
                . 'JOIN     o.ciudad c '
                . 'JOIN     o.tienda t '
                . 'WHERE    o.revisada = true '
                . '         AND o.fecha_publicacion < :fecha '
                . '         AND c.slug = :ciudad '
                . 'ORDER BY o.fecha_publicacion DESC';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'fecha' => $fechaPublicacion,
            'ciudad' => $ciudad
        ));
        $consulta->setMaxResults(1);
        
        return $consulta->getSingleResult();
    }
}
