<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/AlergiasDAO.php';
require_role('gerente');
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    AlergiasDAO::borrar($id);
}
header('Location:' . RUTA_APP . '/vistas/alergias/mostrarAlergias.php');
exit;