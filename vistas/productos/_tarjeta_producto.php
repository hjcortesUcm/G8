<?php

require_once __DIR__ . '/../../includes/AlergenoProductoDAO.php';
require_once __DIR__ . '/../../includes/AlergenoDAO.php';

$alergenos_tarjeta = \AlergenoProductoDAO::getAlergenosProducto($p->getId()); ?>

<article class="producto-card panel mb-15">

    <div class="producto-card-inner">

        <div class="producto-img-box">
            <img src="../../<?= trim($p->getImagen()) ?>"
                alt="<?= htmlspecialchars($p->getNombre(), ENT_QUOTES, 'UTF-8') ?>" width="140" height="100"
                class="img-rounded">
        </div>

        <div class="producto-info-box">

            <h3><?= htmlspecialchars($p->getNombre()) ?></h3>

            <p>
                <?= htmlspecialchars($p->getDescripcion()) ?>
            </p>

            <?php if (!empty($alergenos_tarjeta)): ?>
                <p><strong>Alergenos:</strong></p>
                <ul class="lista-caracteristicas">
                    <?php foreach ($alergenos_tarjeta as $a): ?>
                        <li>
 
                            <?php $alergeno = AlergenoDAO::getById($a->getAlergeno_id());?>
                            <?= htmlspecialchars($alergeno->getNombre()) ?>

                            <?php if ($alergeno->getImagen()): ?>
                                <div class="producto-imagen">
                                    <img src="<?= htmlspecialchars(RUTA_APP . '/' . $alergeno->getImagen()) ?>" alt="<?= htmlspecialchars($alergeno->getNombre()) ?>">
                                </div>
                            <?php endif; ?>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>



            <p>
                <strong>Precio base:</strong>
                <?= number_format((float) $p->getPrecio(), 2) ?> €
            </p>

            <p>
                <strong>IVA:</strong>
                <?= (int) $p->getIVA() ?>%
            </p>

            <p>
                <strong>Precio final:</strong>
                <?= number_format((float) $p->getPrecioFinal(), 2) ?> €
            </p>

            <p>
                <strong>Estado:</strong>
                <?= $p->isOfertado() ? 'Activo' : 'No ofertado' ?>
            </p>

            <a class="btn primary"
                href="crearProducto.php?id=<?= (int) $p->getId() ?>&categoria_id=<?= (int) $categoria_id ?>">
                Editar
            </a>

        </div>

    </div>

</article>