<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/AlergiasDAO.php';
require_once __DIR__ . '/../../includes/Formulario/FormularioAlergia.php';

use es\ucm\fdi\aw\Formulario\FormularioAlergia;

$user = current_user();
if (!$user || !user_has_role($user, 'gerente')) {
    header('Location: ../../index.php');
    exit();
}



$form = new FormularioAlergia();
$htmlFormAlergia = $form->gestiona();

$tituloAccion = 'Nuevo Alergia';
$tituloPagina = $tituloAccion;
$rutaCSS = '../../CSS/estilo.css';
ob_start();
?>
<div class="panel">
    <h2><?= htmlspecialchars($tituloAccion) ?></h2>
    <?= $htmlFormAlergia ?>
    <div class="mt-20">
        <a class="btn" href="mostrarAlergias.php">&laquo; Cancelar</a>
    </div>
</div>
<?php
$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/../../includes/plantilla.php';