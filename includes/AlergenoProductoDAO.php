<?php
require_once __DIR__ . '/application.php';
require_once __DIR__ . '/../entities/AlergenoProducto.php';

class AlergenoProductoDAO
{
    public static function addAlergeno($producto_id, $alergeno_id)
    {
        global $conn;

        $stmt = $conn->prepare(
            "INSERT INTO alergenos_en_productos (producto_id, alergeno_id)
             VALUES (?, ?)"
        );

        $stmt->bind_param("ii", $producto_id, $alergeno_id);
        $stmt->execute();
        $stmt->close();
    }

    public static function getAlergenosProducto($producto_id)
    {
        global $conn;

        $stmt = $conn->prepare(
            "SELECT aep.*, a.id
             FROM alergenos_en_productos aep
             JOIN alergenos a ON a.id = aep.alergeno_id
             WHERE aep.producto_id = ?"
        );

        $stmt->bind_param("i", $producto_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $alergenos = [];

        while ($fila = $result->fetch_assoc()) {
            $alergenos[] = new AlergenoProducto(
                $fila['id'],
                $fila['producto_id'],
                $fila['alergeno_id']
            );
        }

        $result->free();
        $stmt->close();

        return $alergenos;
    }


    public static function limpiarAlergenosProducto($producto_id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM alergenos_en_productos WHERE producto_id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $stmt->close();
    }

    public static function updateAlergenosProducto($producto_id, $alergenos_idl)
    {

        AlergenoProductoDAO::limpiarAlergenosProducto($producto_id);

        if (!empty($alergenos_idl)) {

            foreach ($alergenos_idl as $alergenos_id) {
                AlergenoProductoDAO::addAlergeno($producto_id, $alergenos_id);
            }
        }
        return true;
    }
}
