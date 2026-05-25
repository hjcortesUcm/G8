<tr>

<td data-label="ID"><?= (int)$cat->getId() ?></td>

<td data-label="Nombre"><?= escaparHtml($cat->getNombre()) ?></td>

<td data-label="Imagen"><img src="../../<?= trim($cat->getImagen()) ?>"></td>

</tr>