<?php


require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/AlergiasDAO.php';

$alergias = AlergiasDAO::getAll();

$user = current_user();
if (!$user || !user_has_role($user, 'gerente')) {
    $tituloPagina = 'Acceso bloqueado';
    $rutaCSS = '../../CSS/estilo.css';

    ob_start();
    ?>
    <div class="panel">
        <h1>Acceso bloqueado</h1>
        <p>Necesitas ser gerente para acceder a alergias.</p>
        <a class="btn-volver" href="../../index.php">Volver</a>
    </div>
    <?php
    $contenidoPrincipal = ob_get_clean();
    require __DIR__ . '/../../includes/plantilla.php';
    exit;
}

$tituloPagina = 'Alergias';
$rutaCSS = '../../CSS/estilo.css';

ob_start();
?>

<h1>Lista de alergias</h1>

<p>
    <a href="crearAlergia.php" class="btn-nuevo">+ Nueva alergia</a>
</p>

<?php if (empty($alergias)): ?>
    <p>No hay alergias.</p>
<?php else: ?>
    <table class="tabla tabla-movil">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alergias as $cat): ?>
                <?php require __DIR__ . '/_fila_alergia.php'; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p>
    <a href="../../index.php" class="btn-volver">Volver</a>
</p>

<?php
$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/../../includes/plantilla.php';
