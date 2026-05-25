<?php
require_once __DIR__ . '/../entities/Alergias.php';
require_once __DIR__ . '/application.php';

class AlergiasDAO
{


    public static function getAll()
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM alergias");
        $stmt->execute();

        $result = $stmt->get_result();
        $alergias = [];

        while ($fila = $result->fetch_assoc()) {
            $alergias[] = new Alergias(
                $fila['id'],
                $fila['nombre'],
                $fila['imagen']
            );
        }

        $result->free();
        $stmt->close();

        return $alergias;
    }

    public static function getById($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM alergias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        if (!$row)
            return null;

        return new Alergias(
            $row['id'],
            $row['nombre'],
            $row['imagen']
        );
    }

    public static function create($nombre, $imagen)
    {
        global $conn;

        $stmt = $conn->prepare("
            INSERT INTO alergias
            (nombre, imagen)
            VALUES (?, ?)
        ");

        $stmt->bind_param(
            "ss",
            $nombre,
            $imagen
        );

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function update($id, $nombre, $imagen) {

        global $conn;

        $sql = " UPDATE alergias SET nombre=?, imagen=? WHERE id=? ";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ssi",
            $nombre,
            $imagen,
            $id
        );


        $ok = $stmt->execute();

        $stmt->close();

        return $ok;

    }

    public static function borrar($id)
    {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM alergias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();


        return $ok;
    }

   
}