<?php

class AlergenoProducto
{

    private $id;
    private $producto_id;
    private $alergeno_id;
  
    public function __construct($id, $producto_id, $alergeno_id)
    {
        $this->id = $id;
        $this->producto_id = $producto_id;
        $this->alergeno_id = $alergeno_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAlergeno_id()
    {
        return $this->alergeno_id;
    }

    public function getProductoId()
    {
        return $this->producto_id;
    }

}
