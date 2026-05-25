<?php

class Alergias {

    private $id;
    private $nombre;
    private $imagen;
    

    public $cantidad = 0;

    public function __construct($id, $nombre, $imagen = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getImagen() {
        return $this->imagen;
    }

}