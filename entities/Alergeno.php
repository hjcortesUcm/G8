<?php

class Alergeno {

    private $id;
    private $nombre;
    private $alergias_info;
    private $activo;

    public function __construct($id, $nombre, $alergias_info, $activo = 1) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->alergias_info = $alergias_info;
        $this->activo = $activo;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getIcono(){

        return '/img/alergenos/';
    }

    public function getAlergiasInfo() {
        return $this->alergias_info;
    }

    public function isActivo() {
        return $this->activo;
    }
}