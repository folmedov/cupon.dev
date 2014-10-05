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
                . '         AND o.fecha_publicacion = :fecha '
                . '         AND c.slug = :ciudad '
                . 'ORDER BY o.fecha_publicacion DESC';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'fecha' => $fechaPublicacion,
            'ciudad' => $ciudad
        ));
        $consulta->setMaxResults(1);
        
        return $consulta->getSingleResult();
    }
    
    public function findOferta($ciudad, $slug) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   o, c, t '
                . 'FROM     OfertaBundle:Oferta o '
                . 'JOIN     o.ciudad c '
                . 'JOIN     o.tienda t '
                . 'WHERE    o.revisada = true '
                . '         AND c.slug = :ciudad '
                . '         AND o.slug = :slug';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'ciudad' => $ciudad,
            'slug' => $slug
        ));
        $consulta->setMaxResults(1);
        
        return $consulta->getSingleResult();
    }
    
    public function findRelacionadas($ciudad) {
        $fechaPublicacion = new \DateTime('today');
        
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   o, c '
                . 'FROM     OfertaBundle:Oferta o '
                . 'JOIN     o.ciudad c '
                . 'WHERE    o.revisada = true '
                . '         AND c.slug != :ciudad '
                . '         AND o.fecha_publicacion <= :fecha '
                . 'ORDER BY o.fecha_publicacion DESC';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'ciudad' => $ciudad, 
            'fecha' => $fechaPublicacion
        ));
        $consulta->setMaxResults(5);
        
        return $consulta->getResult();
    }
    
    public function findRecientes($ciudad_id) {
        $fechaPublicacion = new \DateTime('today');
        
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   o, t '
                . 'FROM     OfertaBundle:Oferta o '
                . 'JOIN     o.tienda t '
                . 'WHERE    o.revisada = true '
                . '         AND o.fecha_publicacion < :fecha '
                . '         AND o.ciudad = :id '
                . 'ORDER BY o.fecha_publicacion DESC';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'fecha' => $fechaPublicacion, 
            'id' => $ciudad_id
        ));
        $consulta->setMaxResults(5);
        
        return $consulta->getResult();
    }
}
