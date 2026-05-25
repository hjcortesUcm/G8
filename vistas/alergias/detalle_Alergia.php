<?php
session_start();

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/application.php';

require_once __DIR__ . '/../../includes/AlergiaEnProductoDAO.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: ../productos/detalle_Producto.php');
    exit();
}

$alergia = AlergiasDAO::getById($id);

if (!$producto) {
    header('Location: ../productos/detalle_Producto.php');
    exit();
}

$tituloPagina = 'Detalle de Alergia | Bistro FDI';
$rutaCSS = RUTA_APP . '/CSS/estilo.css';

ob_start();
?>

<main>
    <div class="panel">
        <h2>Detalles de <?= htmlspecialchars($alergia->getNombre()) ?></h2>

        <div class="producto-detalle-contenedor">
            <?php if ($alergia->getImagen()): ?>
                <div class="producto-imagen">
                    <img src="<?= htmlspecialchars(RUTA_APP . '/' . $alergia->getImagen()) ?>" alt="<?= htmlspecialchars($alergia->getNombre()) ?>">
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/../../includes/plantilla.php';
?>