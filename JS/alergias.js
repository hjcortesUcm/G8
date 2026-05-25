document.addEventListener('DOMContentLoaded', () => {

    if (typeof alergiasSeleccionados !== 'undefined' && alergiasSeleccionados.length > 0) {
        alergiasSeleccionados.forEach(a => crearSelectorAlergia(a.id));
    }
    

    const btnAñadir = document.getElementById('AddAlergia');
    if(btnAñadir) {
        btnAñadir.addEventListener('click', () => crearSelectorAlergia());
        // Cambia el texto para que tenga más sentido
        btnAñadir.textContent = "Añadir Alergia"; 
    }
});

function crearSelectorAlergia(idSeleccionado = '') {
    const contenedor = document.getElementById('contenedorAlergiasDinamicos');
    if (!contenedor) return;

    const div = document.createElement('div');
    div.classList.add('alergia-item'); 

    let opciones = '<option value="">Selecciona Alergia</option>';

    if (typeof alergiasDisponibles !== 'undefined') {
        alergiasDisponibles.forEach(a => {
            const selected = (idSeleccionado == a.id) ? 'selected' : '';
            opciones += `<option value="${a.id}" ${selected}>${a.nombre}</option>`;
        });
    }

    div.innerHTML = `
        <select name="alergias_ids[]" class="selector-alergia" required>
            ${opciones}
        </select>
        
        <button type="button" class="eliminar-alergia">X</button>
    `;

    contenedor.appendChild(div);

    div.querySelector('.eliminar-alergia').addEventListener('click', function() {
        div.remove();
    });
}