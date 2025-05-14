const tablaContent = document.getElementById('tabla-personas');
const formPersonas = document.getElementById('form-persona');
const formTitle = document.getElementById('form-title');
const btnCancelar = document.getElementById('btn-cancelar');


async function cargarPersonas() {
    try {
        const response = await fetch(`./src/php/datos.php`);
        const { success, message, data } = await response.json();
        if (!success) {
            tablaContent.innerHTML = `<p class="text-red-500">${message}</p>`;
            return;
        }
        if (data.length === 0) {
            tablaContent.innerHTML = `<p class="text-yellow-500">No hay registros en personas.</p>`;
            return;
        }

        tablaContent.innerHTML = data.map(persona => `
            <tr class="hover:bg-gray-100" id="persona-${persona.id}">
                <td class="px-4 py-2 border">${persona.cedula}</td>
                <td class="px-4 py-2 border">${persona.nombre}</td>
                <td class="px-4 py-2 border">${persona.apellido}</td>
                <td class="px-4 py-2 border">${persona.correo}</td>
                <td class="px-4 py-2 border">${persona.departamento}</td>
                <td class="px-4 py-2 border">${persona.telefono}</td>
                <td class="px-4 py-2 border">${persona.estado}</td>
                <td class="px-4 py-2 border">${persona.fecha_nacimiento}</td>
                <td class="px-4 py-2 border">
                <button onclick="cargarDatosFormulario(${persona.id})" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 mr-2">
                    Editar
                </button>
                <button onclick="eliminarUsuario(${persona.id})" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 mr-2">
                    Eliminar
                </button>
                </td>
            </tr>
            `).join('');



    } catch (error) {
        console.error('Error al cargar la tabla:', error);
        container.innerHTML = `
            <p class='text-red-500'>Error al cargar ${tabla}: ${error.message}</p>
        `;
    }
}

function cargarDatosFormulario(persona) {
    // Cambiar el título del formulario
    formTitle.textContent = 'Actualizar Persona';
    
    //Obtener los datos de la persona seleccionada
    const personaDatos = document.getElementById(`persona-${persona}`);
    if (!personaDatos) {
        alert('Persona no encontrada');
        return;
    }
    
    // Llenar el formulario con los datos de la persona seleccionada
    document.getElementById('persona-id').value = persona;
    document.getElementById('nombre').value = personaDatos.children[1].textContent;
    document.getElementById('apellido').value = personaDatos.children[2].textContent;
    document.getElementById('cedula').value = personaDatos.children[0].textContent;
    document.getElementById('correo').value = personaDatos.children[3].textContent;
    document.getElementById('departamento').value = personaDatos.children[4].textContent;
    document.getElementById('telefono').value = personaDatos.children[5].textContent;
    document.getElementById('estado').value = personaDatos.children[6].textContent;
    document.getElementById('fecha_nacimiento').value = personaDatos.children[7].textContent;
    
    // // Cambiar el texto del botón
    document.getElementById('btnForm').innerText = 'Actualizar';
    btnCancelar.classList.remove('hidden');
}

formPersonas.addEventListener('submit', async (event) => {
    event.preventDefault();
    const formData = new FormData(formPersonas);
    const isNewUser = formPersonas.children[0].value === 'registro';

    try {
        const response = await fetch(`./src/php/registroDatos.php`, {
            method: 'POST',
            body: formData,
        });
        const { success, message } = await response.json();
        if (success) {
            alert(message);
            formPersonas.reset();
            if(!isNewUser) {
                document.getElementById('persona-id').value = 'registro';
                document.getElementById('btnForm').innerText = 'Registrar';
                btnCancelar.classList.add('hidden');
            }
            cargarPersonas();
        } else {
            alert(message);
        }
    } catch (error) {
        console.error('Error al enviar el formulario:', error);
    }
});

function cancelar(){
    formTitle.textContent = 'Registrar Persona';
    formPersonas.reset();
    document.getElementById('btnForm').innerText = 'Registrar';
    document.getElementById('persona-id').value = 'registro';
    btnCancelar.classList.add('hidden');
}

async function  eliminarUsuario(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
        try {
            const response = await fetch(`./src/php/eliminarDatos.php?id=${id}`, {
                method: 'DELETE',
            });
            const { success, message } = await response.json();
            if (success) {
                alert(message);
                cargarPersonas();
            } else {
                alert(message);
            }
        } catch (error) {
            console.error('Error al eliminar el usuario:', error);
        }
        fetch(`./src/php/eliminarDatos.php?id=${id}`, {
            method: 'DELETE',
        })
        // .then(response => response.json())
        // .then(data => {
        //     if (data.success) {
        //         alert(data.message);
        //         cargarPersonas();
        //     } else {
        //         alert(data.message);
        //     }
        // })
        // .catch(error => console.error('Error al eliminar el usuario:', error));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    cargarPersonas();
});