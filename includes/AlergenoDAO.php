<?php
require_once __DIR__ . '/../entities/Alergeno.php';
require_once __DIR__ . '/application.php';


class AlergenoDao {

    public static function getAll(): array {
        global $conn;

        $stmt = $conn-> prepare("SELECT * FROM alergenos ORDER BY id ASC");
        $stmt-> execute();

        $result = $stmt-> get_result();
        $alergenos = [];

        while ($fila = $result -> fetch_assoc()) {
        $alergenos[] = new Alergeno(
          $fila['id'],
          $fila['nombre'],
          $fila['iconoGrande'],
          $fila['iconoPequeño'] 
        );
        }
        $result->free();
        $stmt-> close();

        return $alergenos;
    }

     public static function getByProductoId(int $producto_id): array {
         global $conn;

        $stmt = $conn-> prepare (
            "SELECT a.* 
            FROM alergenos a
            JOIN producto_alergenos pa ON a.id = pa.alergeno_id
            WHERE pa.producto_id = ?
            ORDER BY a.id ASC");
        $stmt-> bind_param("i", $producto_id);
        $stmt-> execute();

        $result = $stmt-> get_result();
        $alergenos = [];

        while ($fila = $result -> fetch_assoc()) {
        $alergenos[] = new Alergeno(
          $fila['id'],
          $fila['nombre'],
          $fila['iconoGrande'],
          $fila['iconoPequeño'] 
        );
        }
        $result->free();
        $stmt-> close();

        return $alergenos;
    }

    public static function getIdsByProductoId(int $producto_id): array {
         global $conn;

        $stmt = $conn-> prepare (
            "SELECT alergeno_id
            FROM producto_alergenos
            WHERE producto_id = ?");
        $stmt-> bind_param("i", $producto_id);
        $stmt-> execute();

        $result = $stmt-> get_result();
        $ids = [];

        while ($fila = $result -> fetch_assoc()) {
        $ids[] = (int) $fila['alergeno_id'];
        }
        $result->free();
        $stmt-> close();

        return $ids;
    }

    public static function replaceProdcutoAlergenos(int $producto_id, array $alergenos_ids): bool {
         global $conn;

         $alergenos_ids = array_values(array_unique(array_map('intval', $alergenos_ids)));
        $stmtDelate = $conn-> prepare (
            "DELATE FROM producto_alergenos
            WHERE producto_id = ?");
        $stmtDelate-> bind_param("i", $producto_id);
        $okDelate = $stmtDelate-> execute();
        $stmtDelate-> close();
        if (!$okDelate){
            return false;
        }
        if (empty($alergenos_ids)){
            return false;
        }

        $stmtInsert = $conn-> prepare (
            "INSERT INTO producto_alergenos (producto_id, alergeno_id)
            VALUES (?,?)");
        foreach($alergenos_ids as $alergeno_id){
            $stmtInsert-> bind_param("ii", $producto_id, $alergeno_id);
            if ($stmtInsert-> execute()){
                $stmtInsert-> close();
                return false;
            }
        }
        $stmtInsert-> close();

        return true;
    }
}