<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\TiendaBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Description of TiendaRepository
 *
 * @author francisco
 */
class TiendaRepository extends EntityRepository {
    //put your code here
    
    public function findUltimasOfertasPublicadas($tienda_id, $limite = 10) {
        $fechaPublicacion = new \DateTime('today - 1 seconds');
        
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   o, t '
                . 'FROM     OfertaBundle:Oferta o '
                . 'JOIN     o.tienda t '
                . 'WHERE    o.revisada = true '
                . '         AND o.fecha_publicacion < :fecha '
                . '         AND o.tienda = :id '
                . 'ORDER BY o.fecha_expiracion DESC';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'fecha' => $fechaPublicacion,
            'id' => $tienda_id
        ));
        $consulta->setMaxResults($limite);
        
        return $consulta->getResult();
    }
    
    public function findCercanas($tienda, $ciudad) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   t, c '
                . 'FROM     TiendaBundle:Tienda t '
                . 'JOIN     t.ciudad c '
                . 'WHERE    c.slug = :ciudad '
                . '         AND t.slug != :tienda';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'ciudad' => $ciudad, 
            'tienda' => $tienda
        ));
        $consulta->setMaxResults(5);
        
        return $consulta->getResult();
    }
    
}
