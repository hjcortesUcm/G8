<?php


require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/AlergiasDAO.php';
require_once __DIR__ . '/../../includes/Formulario/FormularioAlergia.php';

use es\ucm\fdi\aw\Formulario\FormularioAlergia;

$user = current_user();
if (!$user || !user_has_role($user, 'gerente')) {
    http_response_code(403);
    die('Acceso denegado');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    die('ID inválido');
}

$alergia = AlergiasDAO::getById($id);
if (!$alergia) {
    http_response_code(404);
    die('Alergia no encontrada');
}

$form = new FormularioAlergia($alergia);
$htmlForm = $form->gestiona();

$tituloPagina = 'Editar alergia';
$rutaCSS = '../../CSS/estilo.css';

ob_start();
?>
<div class="panel">
    <h1>Editar alergia</h1>
    <?= $htmlForm ?>
    <p><a class="btn-volver" href="<?= RUTA_APP ?>/vistas/alergias/mostrarAlergias.php">← Volver</a></p>
</div>
<?php
$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/../../includes/plantilla.php';
