<?php

namespace es\ucm\fdi\aw\Formulario;

require_once __DIR__ . '/Formulario.php';
require_once __DIR__ . '/../AlergenoDAO.php';

class FormularioAlergeno extends Formulario {

    private $alergeno;

    public function __construct($alergeno = null) {
        parent::__construct('formAlergeno');
        $this->alergeno = $alergeno;
    }

    protected function generaCamposFormulario(&$datos) {

        $nombre = htmlspecialchars(
            $datos['nombre'] ??
            ($this->alergeno ? $this->alergeno->getNombre() : ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $alergias = htmlspecialchars(
            $datos['alergias_info'] ??
            ($this->alergeno ? $this->alergeno->getAlergiasInfo() : ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $textoBoton = $this->alergeno
            ? 'Actualizar alergeno'
            : 'Crear alergeno';

        return <<<HTML

<p>
<label>Alergeno:</label><br>
<input
type="text"
name="nombre"
value="{$nombre}"
required>
</p>

<p>
<label>Informacion adicional:</label><br>
<textarea
name="alergias_info"
placeholder="trigo, cebada y centeno...">{$alergias}</textarea>
</p>

<p>
<button type="submit">
{$textoBoton}
</button>
</p>

HTML;
    }

    protected function procesaFormulario(&$datos) {

        $this->errores = [];

        $nombre = trim((string)($datos['nombre'] ?? ''));
        $alergias_info = trim((string)($datos['alergias_info'] ?? ''));

        if ($nombre === '') {
            $this->errores[] = 'El nombre es obligatorio.';
            return;
        }

        if ($alergias_info === '') {
            $alergias_info = 'ninguna alergia';
        }

        if ($this->alergeno) {
            $ok = \AlergenoDAO::update(
                $this->alergeno->getId(),
                $nombre,
                $alergias_info
            );
        } else {
            $ok = \AlergenoDAO::create(
                $nombre,
                $alergias_info
            );
        }

        if (!$ok) {
            $this->errores[] = 'No se pudo guardar el alergeno.';
            return;
        }

        $this->urlRedireccion = 'mostrarAlergenos.php';
    }
}