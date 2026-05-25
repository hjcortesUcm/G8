<?php
require_once __DIR__ . '/../entities/Alergeno.php';
require_once __DIR__ . '/application.php';
    require_once __DIR__ . '/AlergenoProductoDAO.php';

class AlergenoDAO
{


    public static function getAll()
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM alergenos");
        $stmt->execute();

        $result = $stmt->get_result();
        $alergenos = [];

        while ($fila = $result->fetch_assoc()) {
            $alergenos[] = new Alergeno(
                $fila['id'],
                $fila['nombre'],
                $fila['imagen']
            );
        }

        $result->free();
        $stmt->close();

        return $alergenos;
    }

    public static function getById($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM alergenos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        if (!$row)
            return null;

        return new Alergeno(
            $row['id'],
            $row['nombre'],
            $row['imagen']
        );
    }




}
