<?php

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/Formulario/FormularioAlergeno.php';

use es\ucm\fdi\aw\Formulario\FormularioAlergeno;

$user = current_user();

if (!$user || !user_has_role($user, 'gerente')) {
    http_response_code(403);
    die('Acceso denegado');
}

$form = new FormularioAlergeno();
$htmlForm = $form->gestiona();

$tituloPagina = 'Nuevo alergeno';
$rutaCSS = '../../CSS/estilo.css';

ob_start();
?>

<div class="panel">
    <h1>Nuevo alergeno</h1>

    <?= $htmlForm ?>

    <p>
        <a class="btn-volver" href="mostrarAlergenos.php">Cancelar</a>
    </p>
</div>

<?php

$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/../../includes/plantilla.php';