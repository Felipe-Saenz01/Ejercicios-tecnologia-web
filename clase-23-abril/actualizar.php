<?php
include './src/conexion/conexion.php';

if(isset($_POST['actualizar'])) {
    $consulta = $db->prepare('UPDATE personas SET nombre = :nombre, apellido = :apellido, correo = :correo, cedula = :cedula WHERE id = :id');
    $consulta->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
    $consulta->bindParam(':apellido', $_POST['apellido'], PDO::PARAM_STR);
    $consulta->bindParam(':correo', $_POST['correo'], PDO::PARAM_STR);
    $consulta->bindParam(':cedula', $_POST['cedula'], PDO::PARAM_INT);
    $consulta->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    $consulta->execute();


    header('Location: ./index.php');
    exit;
}else{
}
$id = $_GET['id'];

$sql = 'SELECT * FROM personas WHERE id = :id';

$consulta = $db->prepare($sql);
$consulta->bindParam(':id', $id, PDO::PARAM_INT);
$consulta->execute();

$response = $consulta->fetch(PDO::FETCH_OBJ);




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
    <div class="flex items-center  container mx-auto my-5 min-h-screen bg-neutral-200 rounded rouded-3xl">
        <div class="w-3/5 mx-auto bg-white shadow-md rounded-lg overflow-hidden my-4 mx-auto p-4">
            <h1 class="text-2xl font-bold mx-4 text-center">Actualizar Persona</h1>
            <form action="./actualizar.php?id=<?= $response->id ?>" method="POST" class="">
                <input type="hidden" name="id" value="<?= $response->id ?>">
                <input type="hidden" name="actualizar" value="true">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" value="<?= $response->nombre ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="apellido" class="block text-gray-700 text-sm font-bold mb-2">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" value="<?= $response->apellido ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="correo" class="block text-gray-700 text-sm font-bold mb-2">Correo:</label>
                    <input type="email" name="correo" id="correo" value="<?= $response->correo ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="cedula" class="block text-gray-700 text-sm font-bold mb-2">Cédula:</label>
                    <input type="text" name="cedula" id="cedula" value="<?= $response->cedula ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <button type="submit" class="bg-amber-600 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded">
                    Actualizar
                </button>
            </form>
        </div>
    </div>
</body>
</html>