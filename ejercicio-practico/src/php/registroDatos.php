<?php
header('Content-Type: application/json');
// ob_clean();

include '../conection/conexion.php';

$persona = $_POST['persona-id'];

try {

    //Validar la cedula
    $sqlCedula = 'SELECT COUNT(*) FROM personas WHERE cedula = :cedula';
    $consultaCedula = $db->prepare($sqlCedula);
    $consultaCedula->bindParam(':cedula', $_POST['cedula'], PDO::PARAM_INT);
    $consultaCedula->execute();
    $countCedula = $consultaCedula->fetchColumn();
    if ($countCedula > 0 && $persona == 'registro') {
        echo json_encode([
            'success' => false,
            'message' => 'La cédula ya está registrada',
        ]);
        exit;
    }
    //Validar registro o actualización
    if ($persona == 'registro') {
        $sql = 'INSERT INTO personas (nombre, apellido, cedula, correo, departamento, telefono, estado, fecha_nacimiento) 
                VALUES (:nombre, :apellido, :cedula, :correo, :departamento, :telefono, :estado, :fecha_nacimiento)';

        $consulta = $db->prepare($sql);
        $consulta->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $consulta->bindParam(':apellido', $_POST['apellido'], PDO::PARAM_STR);
        $consulta->bindParam(':correo', $_POST['correo'], PDO::PARAM_STR);
        $consulta->bindParam(':cedula', $_POST['cedula'], PDO::PARAM_INT);
        $consulta->bindParam(':departamento', $_POST['departamento'], PDO::PARAM_STR);
        $consulta->bindParam(':telefono', $_POST['telefono'], PDO::PARAM_INT);
        $consulta->bindParam(':estado', $_POST['estado'], PDO::PARAM_STR);
        $consulta->bindParam(':fecha_nacimiento', $_POST['fecha_nacimiento'], PDO::PARAM_STR);

        $consulta->execute();
        $response = $consulta->fetch(PDO::FETCH_OBJ);
        echo json_encode([
            'success' => true,
            'message' => 'Persona registrada correctamente',
        ]);
    } else {
        $sql = 'UPDATE personas SET nombre = :nombre, apellido = :apellido, cedula = :cedula, correo = :correo, departamento = :departamento, telefono = :telefono, estado = :estado, fecha_nacimiento = :fecha_nacimiento WHERE id = :id';

        $consulta = $db->prepare($sql);
        $consulta->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $consulta->bindParam(':apellido', $_POST['apellido'], PDO::PARAM_STR);
        $consulta->bindParam(':correo', $_POST['correo'], PDO::PARAM_STR);
        $consulta->bindParam(':cedula', $_POST['cedula'], PDO::PARAM_INT);
        $consulta->bindParam(':departamento', $_POST['departamento'], PDO::PARAM_STR);
        $consulta->bindParam(':telefono', $_POST['telefono'], PDO::PARAM_INT);
        $consulta->bindParam(':estado', $_POST['estado'], PDO::PARAM_STR);
        $consulta->bindParam(':fecha_nacimiento', $_POST['fecha_nacimiento'], PDO::PARAM_STR);
        $consulta->bindParam(':id', $_POST['persona-id'], PDO::PARAM_INT);

        $consulta->execute();
        echo json_encode([
            'success' => true,
            'message' => 'Persona actualizada correctamente',
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al consultar la base de datos: ' . $e->getMessage(),
    ]);
}
