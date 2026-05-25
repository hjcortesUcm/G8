<tr>

<td data-label="ID"><?= (int)$cat->getId() ?></td>

<td data-label="Nombre"><?= escaparHtml($cat->getNombre()) ?></td>

<td data-label="Imagen"><img src="../../<?= trim($cat->getImagen()) ?>"></td>



<td data-label="Acciones">
<div class="actions-inline">

<a href="../../scripts/alergias/editarAlergia.php?id=<?= (int)$cat->getId() ?>"
class="btn small primary">
Editar
</a>


<form method="post"
action="../../scripts/alergias/borrarAlergia.php"
onsubmit="return confirm('Borrar alergia?');"
class="d-inline">

<input type="hidden"
name="id"
value="<?= (int)$cat->getId() ?>">

<button class="btn small danger" type="submit">
Borrar
</button>

</form>

</div>
</td>

</tr>