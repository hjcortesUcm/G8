(function (){
    const STORAGE_KEY = 'bistro_alergenos_cliente';

    function leerSeleccion(){
        try{
            const raw = localStorage.getItem(STORAGE_KEY);
            const data = raw ? JSON.parse(raw) : [];
            if (!Array.isArray(data)) {
                return [];
            }
            return data.map(Number).filter(n => !Number.isNaN(n) && n > 0);
        }
        catch (e) {
            return [];
        }
    }

    function guardarSeleccionIds(ids){
        localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
    }

     function parseIds(valor){
        if (!valor){
            return[];
        }
        return valor.split(',').map(v=> parseInt(v, 10)).filter(v=> !Number.isNaN(v));
    }

    function hayCruce(idsProducto, idsSeleccionados){
        return idsProducto.some(id=> idsSeleccionados.includes(id));
    }

    function actualizarSelectoresGrandes(idsSeleccionados){
        document.querySelectorAll('fila-producto-catalogo').forEach(function (btn){
            const id = parseInt(btn.dataset.AlergenoId || '0', '10');
            const activo = idsSeleccionados.includes(id);

            btn.classList.toggle('activo',activo);
            btn.setAttribute('aria-presse', activo ? 'true' : 'false');
        });
    }

    function aplicarAdvertencias(idsSeleccionados){
        document.querySelectorAll('fila-producto-catalogo').forEach(function (fila){
            const idsProduto = getIds(fila.dataset.alergenos || " ");
            const nombre = fila.querySelector('.nombre-producto');
            const descripcion = fila.querySelector('.descripcion-producto');
            const boton = fila.querySelector('.btn-add-producto');

            const conflicto = idsSeleccionados.length > 0 && hayCruce(idsProduto, idsSeleccionados);

            if (nombre && !nombre.dataset.originalText){
                nombre.dataset.originalText = nombre.textContent.trim();
            }
            if (descripcion && !descripcion.dataset.originalText){
                descripcion.dataset.originalText = descripcion.textContent.trim();
            }
            if (boton && !boton.dataset.originalText){
                boton.dataset.originalText = boton.textContent.trim();
            }

            if(conflicto){
                fila.classList.add('producto-con-alerta');
                if(nombre && !nombre.dataset.originalText)
                    nombre.textContent = '☠' + nombre.dataset.originalText;
                if (boton) {
                    boton.disabled = true;
                    boton.textContent = 'No Apto';
                    boton.title = 'Contiene uno de los alergenos selecciondos';
                }
                else{
                    fila.classList.remove('producto-con-alerta');
                    if (nombre && !nombre.dataset.originalText){
                      nombre.textContent = nombre.dataset.originalText;
                     }
                    if (descripcion && !descripcion.dataset.originalText){
                      descripcion.textContent = descripcion.dataset.originalText;
                     }
                    if (boton && !boton.dataset.originalText){
                      boton.disabled = false;
                      boton.textContent = boton.dataset.originalText;
                      boton.title = '';
                     }
                }
            }
        });
    }
})();