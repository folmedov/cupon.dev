<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cupon\OfertaBundle\Entity\Oferta;
use Cupon\UsuarioBundle\Entity\Usuario;

/**
 * Description of Venta
 *
 * @author francisco
 * @ORM\Entity
 */
class Venta {
    //put your code here
    
    /** 
     * @var \Datetime 
     * 
     * @ORM\Column(type="datetime") 
     */
    protected $fecha;
    
    /**
     * @var Oferta 
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Cupon\OfertaBundle\Entity\Oferta")
     */
    protected $oferta;
    
    /**
     * @var Usuario 
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Cupon\UsuarioBundle\Entity\Usuario")
     */
    protected $usuario;
    
    /**
     * Get fecha
     *
     * @return \Date 
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Get oferta
     *
     * @return Oferta 
     */
    public function getOferta() {
        return $this->oferta;
    }

    /**
     * Get usuario
     *
     * @return Usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set fecha
     *
     * @param \Datetime $fecha
     * @return Venta
     */
    public function setFecha(\Datetime $fecha) {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * Set oferta
     *
     * @param Oferta $oferta
     * @return Venta
     */
    public function setOferta(Oferta $oferta) {
        $this->oferta = $oferta;
        return $this;
    }

    /**
     * Set usuario
     *
     * @param Usuario $usuario
     * @return Venta
     */
    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
        return $this;
    }


}
