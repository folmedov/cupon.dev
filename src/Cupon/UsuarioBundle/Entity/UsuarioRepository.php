<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\UsuarioBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Description of UsuarioRepository
 *
 * @author francisco
 */
class UsuarioRepository extends EntityRepository {
    //put your code here
    
    public function findTodasLasCompras($usuario) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   v, o, t '
                . 'FROM     OfertaBundle:Venta v '
                . 'JOIN     v.oferta o '
                . 'JOIN     o.tienda t '
                . 'WHERE    v.usuario = :id '
                . 'ORDER BY v.fecha DESC';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'id' => $usuario
        ));
        
        return $consulta->getResult();
    }
}
