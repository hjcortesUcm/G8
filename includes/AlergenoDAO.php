<?php

require_once __DIR__ . '/../entities/Alergeno.php';
require_once __DIR__ . '/application.php';

class AlergenoDAO {

    public static function getAll() {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM alergenos ORDER BY id ASC");
        $stmt->execute();

        $result = $stmt->get_result();
        $alergenos = [];

        while ($row = $result->fetch_assoc()) {
            $alergenos[] = new Alergeno(
                $row['id'],
                $row['nombre'],
                $row['alergias_info'],
                $row['activo']
            );
        }

        $result->free();
        $stmt->close();

        return $alergenos;
    }

    public static function getActivos() {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM alergenos WHERE activo = 1 ORDER BY nombre ASC");
        $stmt->execute();

        $result = $stmt->get_result();
        $alergenos = [];

        while ($row = $result->fetch_assoc()) {
            $alergenos[] = new Alergeno(
                $row['id'],
                $row['nombre'],
                $row['alergias_info'],
                $row['activo']
            );
        }

        $result->free();
        $stmt->close();

        return $alergenos;
    }

    public static function getById($id) {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM alergenos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        if (!$row) {
            return null;
        }

        return new Alergeno(
            $row['id'],
            $row['nombre'],
            $row['alergias_info'],
            $row['activo']
        );
    }

    public static function create($nombre, $alergias_info) {
        global $conn;

        $stmt = $conn->prepare("
            INSERT INTO alergenos (nombre, alergias_info, activo)
            VALUES (?, ?, 1)
        ");

        $stmt->bind_param("ss", $nombre, $alergias_info);

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function update($id, $nombre, $alergias_info) {
        global $conn;

        $stmt = $conn->prepare("
            UPDATE alergenos
            SET nombre = ?, alergias_info = ?
            WHERE id = ?
        ");

        $stmt->bind_param("ssi", $nombre, $alergias_info, $id);

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function desactivar($id) {
        global $conn;

        $stmt = $conn->prepare("UPDATE alergenos SET activo = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function activar($id) {
        global $conn;

        $stmt = $conn->prepare("UPDATE alergenos SET activo = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);

        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function getByProducto($producto_id) {
        global $conn;

        $stmt = $conn->prepare("
            SELECT i.*
            FROM alergenos i
            JOIN alergenos_en_producto ip
                ON i.id = ip.alergeno_id
            WHERE ip.producto_id = ?
            ORDER BY i.nombre ASC
        ");

        $stmt->bind_param("i", $producto_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $alergenos = [];

        while ($row = $result->fetch_assoc()) {
            $alergenos[] = new Alergeno(
                $row['id'],
                $row['nombre'],
                $row['alergias_info'],
                $row['activo']
            );
        }

        $result->free();
        $stmt->close();

        return $alergenos;
    }

    public static function syncProductoAlergenos($producto_id, $alergenos_ids) {
        global $conn;

        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("
                DELETE FROM alergenos_en_producto
                WHERE producto_id = ?
            ");

            $stmt->bind_param("i", $producto_id);
            $stmt->execute();
            $stmt->close();

            if (!empty($alergenos_ids)) {
                $stmtInsert = $conn->prepare("
                    INSERT INTO alergenos_en_producto (producto_id, alergeno_id)
                    VALUES (?, ?)
                ");

                foreach ($alergenos_ids as $alergeno_id) {
                    $alergeno_id = (int)$alergeno_id;
                    $stmtInsert->bind_param("ii", $producto_id, $alergeno_id);
                    $stmtInsert->execute();
                }

                $stmtInsert->close();
            }

            $conn->commit();
            return true;

        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
    }

     public static function getIcono() {

        return null;
     }
}