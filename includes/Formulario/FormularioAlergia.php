<?php
namespace es\ucm\fdi\aw\Formulario;

require_once __DIR__ . '/Formulario.php';
require_once __DIR__ . '/../AlergiasDAO.php';

class FormularioAlergia extends Formulario
{
    private $alergia;

    public function __construct($alergia = null)
    {
        parent::__construct(
            'formAlergia',
            ['enctype' => 'multipart/form-data']
        );

        $this->alergia = $alergia;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = htmlspecialchars(
            $datos['nombre'] ??
            ($this->alergia ? $this->alergia->getNombre() : ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $imagen = htmlspecialchars(
            $datos['imagen'] ??
            ($this->alergia ? $this->alergia->getImagen() : ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $textoBoton = $this->alergia ? 'Actualizar alergia' : 'Crear alergia';

        return <<<HTML

<p>
<label>Nombre:</label><br>
<input
type="text"
name="nombre"
value="{$nombre}"
required>
</p>


<p>
<label>Imagen:</label><br>

<textarea
name="imagen"
required>{$imagen}</textarea>

</p>

<p>
<button type="submit">
{$textoBoton}
</button>
</p>


HTML;

    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre']);
        $imagen = trim($datos['imagen']);


        if ($this->alergia) {
            $ok = \AlergiasDAO::update(
                $this->alergia->getId(),
                $nombre,
                $imagen
            );
        } else {
            $ok = \AlergiasDAO::create(
                $nombre,
                $imagen
            );
        }


        if (!$ok) {

            $this->errores[] =
                'No se pudo guardar';

            return;

        }


        $this->urlRedireccion = RUTA_APP . '/vistas/alergias/mostrarAlergias.php';

    }

}