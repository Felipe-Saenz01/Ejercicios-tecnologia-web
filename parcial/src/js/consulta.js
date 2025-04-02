const datos = document.getElementById('datos');

fetch('./src/php/usuarios.php')
    .then(response => response.json())
    .then(response => {
        console.log(response);
        if (!response.success) {
            // Mostrar error si success es false
            datos.innerHTML = `<p style="color: red;">${response.message}</p>`;
            return;
        }

        // Crear tabla si todo está bien
        let tablaHTML = `
            <table class="table-fixed border-collapse w-2/3 mx-auto">
                <thead class="bg-gray-200 text-gray-700 font-bold border-b h-10">
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
        `;

        // Recorrer los datos (ahora en response.data)
        response.data.forEach(user => {
            tablaHTML += `
        <tr class="border-b my-5 hover:bg-gray-100 my-4 h-10">
            <td>${user.cedula}</td>
            <td>${user.nombre}</td>
            <td>${user.correo}</td>
        </tr>
    `;
        });

        tablaHTML += `
        </tbody>
    </table>
`;

        datos.innerHTML = tablaHTML;
    })
    .catch(error => {
        console.error('Error en la petición:', error);
        datos.innerHTML = '<p style="color: red;">Error al conectarse al servidor</p>';
    });