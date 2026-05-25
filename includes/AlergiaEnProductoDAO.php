<?php
require_once __DIR__ . '/../includes/application.php';
require_once __DIR__ . '/../entities/AlergiaProducto.php';

class AlergiaEnProductoDAO
{
    public static function addAlergia($producto_id, $alergia_id)
    {
        global $conn;

        $stmt = $conn->prepare(
            "INSERT INTO alergias_en_producto (producto_id, alergia_id)
             VALUES (?, ?)"
        );

        $stmt->bind_param("ii", $producto_id, $alergia_id);
        $stmt->execute();
        $stmt->close();
    }

    public static function getAlergiasProducto($producto_id)
    {
        global $conn;

        $stmt = $conn->prepare(
            "SELECT ap.*, a.nombre, a.imagen
             FROM alergias_en_producto ap
             JOIN alergias a ON a.id = ap.alergia_id
             WHERE ap.producto_id = ?"
        );

        $stmt->bind_param("i", $producto_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $alergias = [];

        while ($fila = $result->fetch_assoc()) {
            $alergias[] = new AlergiaProducto(
                $fila['id'],
                $fila['nombre'],
                $fila['imagen'],
                $fila['producto_id'],
                $fila['alergia_id']
            );
        }

        $result->free();
        $stmt->close();

        return $alergias;
    }

    public static function limpiarAlergiasProducto($producto_id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM alergias_en_producto WHERE producto_id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $stmt->close();
    }

}