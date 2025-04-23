<?php
include './src/conexion/conexion.php';

$sql = 'SELECT * FROM personas';

$consulta = $db->prepare($sql);
$consulta->execute();

$response = $consulta->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Clase 23 de Abril</title>
</head>

<body>
    <div class="container mx-auto my-5 min-h-screen bg-neutral-200 rounded rouded-3xl">
        <h1 class="text-2xl font-bold text-center mt-4">Ejercicio Actualizacion de Personas</h1>
        <table class="w-5/6 bg-white shadow-md rounded-lg overflow-hidden my-4 mx-auto">
            <thead>
                <tr class="bg-neutral-700 text-gray-200 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Apellido</th>
                    <th class="py-3 px-6 text-left">Correo</th>
                    <th class="py-3 px-6 text-left">Cédula</th>
                    <th class="py-3 px-6 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($response as $persona) : ?>
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-6 text-left"><?= $persona->nombre ?></td>
                        <td class="py-3 px-6 text-left"><?= $persona->apellido ?></td>
                        <td class="py-3 px-6 text-left"><?= $persona->correo ?></td>
                        <td class="py-3 px-6 text-left"><?= $persona->cedula ?></td>
                        <td>
                            <form action="./actualizar.php" method="GET">
                                <input type="hidden" name="id" value="<?= $persona->id ?>">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                            </form>
                            <!-- <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>

</html>