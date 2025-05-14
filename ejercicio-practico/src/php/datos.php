<?php

include '../conection/conexion.php';

$sql = 'SELECT * FROM personas';

try{
    $consulta = $db->prepare($sql);
    $consulta->execute();
    $response = $consulta->fetchAll(PDO::FETCH_OBJ);
    echo json_encode([
        'success' => true,
        'message' => 'Personas encontradas',
        'data' => $response
    ]);

}catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al consultar la base de datos: ' . $e->getMessage(),
        'data' => []
    ]);
}

