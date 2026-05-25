<?php

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/AlergenoDAO.php';
require_once __DIR__ . '/../../includes/Formulario/FormularioAlergeno.php';

use es\ucm\fdi\aw\Formulario\FormularioAlergeno;

$user = current_user();

if (!$user || !user_has_role($user, 'gerente')) {
    http_response_code(403);
    die('Acceso denegado');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    http_response_code(400);
    die('Alergeno inválido');
}

$alergeno = AlergenoDAO::getById($id);

if (!$alergeno) {
    http_response_code(404);
    die('Alergeno no encontrado');
}

$form = new FormularioAlergeno($alergeno);
$htmlForm = $form->gestiona();

$tituloPagina = 'Editar alergeno';
$rutaCSS = '../../CSS/estilo.css';

ob_start();
?>

<div class="panel">
    <h1>Editar alergeno</h1>

    <?= $htmlForm ?>

    <p>
        <a class="btn-volver" href="mostrarAlergenos.php">Cancelar</a>
    </p>
</div>

<?php

$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/../../includes/plantilla.php';