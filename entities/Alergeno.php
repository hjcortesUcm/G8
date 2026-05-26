<?php

class Alergeno {
    private $id;
    private $nombre;
    private $iconoGrande;
    private $iconoPequeño;

     public function __construct($id, $nombre, $iconoGrande, $iconoPequeño) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->iconoGrande = $iconoGrande;
        $this->iconoPequeño = $iconoPequeño;
    }

    // GETTERS

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getIconoGrande() {
        return $this->iconoGrande;
    }

     public function getIconoPequeño() {
        return $this->iconoPequeño;
    }

     public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setIconoGrande($iconoGrande) {
        $this->iconoGrande = $iconoGrande;
    }

    public function setIconoPequeño($iconoPequeño) {
        $this->iconoPequeño = $iconoPequeño;
    }
}