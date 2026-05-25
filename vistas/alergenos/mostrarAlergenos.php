<?php

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/AlergenoDAO.php';

$user = current_user();

if (!$user || !user_has_role($user, 'gerente')) {
    http_response_code(403);
    die('Acceso denegado');
}

$alergenos = AlergenoDAO::getAll();

$tituloPagina = 'Alergenos';
$rutaCSS = '../../CSS/estilo.css';

ob_start();
?>

<h1>Lista de alergenos</h1>

<p>
    <a class="btn-nuevo" href="crearAlergeno.php">+ Nuevo alergenos</a>
</p>

<?php if (empty($alergenos)): ?>

    <p>No hay alergenos.</p>

<?php else: ?>

<table class="tabla tabla-movil">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Alergias</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($alergenos as $al): ?>
            <tr>
                <td><?= (int)$al->getId() ?></td>

                <td>
                    <?= htmlspecialchars($al->getNombre(), ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars($al->getAlergiasInfo(), ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= $al->isActivo() ? 'Activo' : 'Inactivo' ?>
                </td>

                <td>
                    <a
                    class="btn"
                    href="editarAlergeno.php?id=<?= (int)$al->getId() ?>">
                    Editar
                    </a>

                    <form
                    method="post"
                    action="../../scripts/alergenos/borrarAlergeno.php"
                    style="display:inline">

                        <input
                        type="hidden"
                        name="id"
                        value="<?= (int)$al->getId() ?>">

                        <button
                        type="submit"
                        class="btn-danger">
                        Borrar
                        </button>

                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<p>
    <a class="btn-volver" href="../../index.php">Volver</a>
</p>

<?php

$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/../../includes/plantilla.php';
