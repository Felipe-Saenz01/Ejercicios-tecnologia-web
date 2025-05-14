<?php

include '../conection/conexion.php';
try {
    $sql = 'DELETE FROM personas WHERE id = :id';
    $consulta = $db->prepare($sql);
    $consulta->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $consulta->execute();
    $response = $consulta->fetch(PDO::FETCH_OBJ);
    if ($consulta->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Persona eliminada correctamente',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró la persona o no se pudo eliminar',
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al consultar la base de datos: ' . $e->getMessage(),
    ]);
}


?>