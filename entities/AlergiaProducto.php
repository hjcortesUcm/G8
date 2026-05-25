<?php

class AlergiaProducto
{

    private $id;
    private $nombre;
    private $imagen;
    private $producto_id;
    private $alergia_id;


    public function __construct($id, $nombre, $imagen, $producto_id, $alergia_id)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
        $this->producto_id = $producto_id;
        $this->alergia_id = $alergia_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getAlergia_id()
    {
        return $this->alergia_id;
    }

    public function getProductoId()
    {
        return $this->producto_id;
    }

}