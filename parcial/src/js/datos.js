const btnPersonas = document.getElementById('personas');
const btnEmpresas = document.getElementById('empresas');
const btnContratos = document.getElementById('contratos');

const modalContainer = document.getElementById('modal-container');
const modalTitle = document.getElementById('modal-title');
const modalBody = document.getElementById('modal-body');

async function cargarTabla(tabla) {
    const container = document.getElementById('tabla-container');
    const messageResponse = document.getElementById('message');

    try {
        const response = await fetch(`./src/php/datos.php?tabla=${tabla}`);
        const { success, message, data } = await response.json();

        if (!success) {
            container.innerHTML = `<p class="text-red-500">${message}</p>`;
            return;
        }

        if (data.length === 0) {
            container.innerHTML = `<p class="text-yellow-500">No hay registros en ${tabla}.</p>`;
            return;
        }

        let html = `
            <div class="overflow-x-auto">
                <table class="min-w-2/3 bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            ${Object.keys(data[0]).map(key => `
                                <th class="px-4 py-2 text-left">${key.toUpperCase()}</th>
                            `).join('')}
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        ${data.map(fila => `
                            <tr class="hover:bg-gray-100">
                                ${Object.values(fila).map(value => `
                                    <td class="px-4 py-2 border">${value || '-'}</td>
                                `).join('')}
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
        messageResponse.innerHTML = message;
        container.innerHTML = html;
        cargarBotones(tabla);

    } catch (error) {
        console.error('Error al cargar la tabla:', error);
        container.innerHTML = `
            <p class='text-red-500'>Error al cargar ${tabla}: ${error.message}</p>
        `;
    }
}


function cargarBotones(tabla) {
    btnPersonas.classList.add('hidden');
    btnEmpresas.classList.add('hidden');
    btnContratos.classList.add('hidden');
    switch (tabla) {
        case 'personas':
            btnPersonas.classList.remove('hidden');
            break;
        case 'empresas':
            btnEmpresas.classList.remove('hidden');
            break;
        case 'contratos':
            btnContratos.classList.remove('hidden');
            break;
    }
}

function showModal(tabla) {
    modalBody.innerHTML = '';

    let inputs = [];

    switch (tabla) {
        case 'personas':
            modalTitle.textContent = 'Agregar Usuario';
            inputs = [
                { label: 'Cedula', name: 'cedula', type: 'text' },
                { label: 'Nombre', name: 'nombre', type: 'text' },
                { label: 'Correo', name: 'correo', type: 'email' },
            ];
            break;
        case 'empresas':
            modalTitle.textContent = 'Agregar Empresa';
            inputs = [
                { label: 'Nit', name: 'nit', type: 'number' },
                { label: 'Nombre', name: 'nombre', type: 'text' },
                { label: 'Correo', name: 'correo', type: 'email' },
            ];
            break;
        case 'contratos':
            modalTitle.textContent = 'Agregar Contrato';
            break;
    }

    if (tabla === 'contratos') {
        contratosInputs();
    } else {
        inputs.forEach(input => {
            modalBody.innerHTML += `
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold">${input.label}</label>
                    <input type="${input.type}" name="${input.name}" class="w-full p-2 border rounded " required>
                </div>
            `;
        });
        modalBody.innerHTML += `<input type="hidden" name="tabla" value="${tabla}">`;
    }

    modalContainer.classList.remove('hidden');

    document.getElementById('modal-form').onsubmit = function (event) {
        event.preventDefault();
        registro(tabla);
    };

}

async function contratosInputs() {
    try {
        const contratos = await fetch('./src/php/contratos.php');
        const { success, message, personas, empresas } = await contratos.json();
        if (!success) {
            console.error('Error al cargar personas y empresas:', message);
            return;
        }

        if (personas.length === 0 && empresas.length === 0) {
            modalBody.innerHTML = `<p class="text-yellow-500">No hay registros en ${tabla}.</p>`;
            return;
        }
        let hiddenTabla = `<input type="hidden" name="tabla" value="contratos">`;
        let selectPersonas = `
            <div class="mb-4">    
                <label class="block text-gray-700 font-bold">Persona</label>
                <select name="persona_id" class="w-full p-2 border rounded" required>
                        <option value="">Seleccione persona</option>
                        ${personas.map(p => `<option value="${p.id}">${p.nombre}</option>`).join('')}
                </select>
            </div>`;

        let selectEmpresas = `
            <div class="mb-4">  
                <label class="block text-gray-700 font-bold">Empresa</label>
                <select name="empresa_id" class="w-full p-2 border rounded" required>
                    <option value="">Seleccione empresa</option>
                    ${empresas.map(e => `<option value="${e.id}">${e.nombre}</option>`).join('')}
                </select>
            </div>`;

        modalBody.innerHTML = selectPersonas + selectEmpresas +hiddenTabla;

    } catch (error) {
        modalBody.innerHTML = `<p class="text-red-500">Error al cargar personas y empresas: ${error.message}</p>`;
    }

}


function exitModal() {
    modalContainer.classList.add('hidden');
}

async function registro(tabla) {
    const formData = new FormData(document.getElementById('modal-form'));

    try {
        const response = await fetch(`./src/php/registroDatos.php`, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert('Registro guardado correctamente');
            exitModal();
            cargarTabla(tabla);
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error al guardar:', error);
    }
}


