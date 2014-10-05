<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\CiudadBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Description of CiudadRepository
 *
 * @author francisco
 */
class CiudadRepository extends EntityRepository {
    
    public function findCercanas($ciudad_id) {
        $em = $this->getEntityManager();
        
        $dql =    'SELECT   c '
                . 'FROM     CiudadBundle:Ciudad c '
                . 'WHERE    c.id != :id '
                . 'ORDER BY c.nombre ASC';
        
        $consulta = $em->createQuery($dql)->setParameters(array(
            'id' => $ciudad_id
        ));
        $consulta->setMaxResults(5);
        
        return $consulta->getResult();
    }
}
