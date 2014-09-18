<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cupon\CiudadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cupon\OfertaBundle\Util\Util;

/**
 * Description of Ciudad
 *
 * @author francisco
 * @ORM\Entity
 */
class Ciudad {
    //put your code here

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $slug;
    
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        $this->slug = Util::getSlug($nombre);
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }
    
    public function __toString() {
        return $this->getNombre();
    }

}
