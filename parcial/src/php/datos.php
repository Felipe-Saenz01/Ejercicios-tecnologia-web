<?php

include './conexion.php';

$tabla = $_GET['tabla'];
$message = '';
switch ($tabla) {
    case 'personas':
        $sql = 'SELECT cedula, nombre, correo FROM personas';
        $message = 'Personas encontradas';
        break;
    case 'empresas':
        $sql = 'SELECT nit, nombre, correo FROM empresas';
        $message = 'Empresas encontradas';
        break;
    case 'contratos':
        $sql = 'SELECT p.nombre as persona, e.nombre as empresa, c.fecha 
                FROM contrato c
                JOIN personas p ON c.persona_id = p.id
                JOIN empresas e ON c.empresa_id = e.id';
        $message = 'Contratos encontrados';
        break;
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Tabla no válida',
            'data' => []
        ]);
        exit;
}

try {
    $consulta = $db->prepare($sql);
    $consulta->execute();

    $response = $consulta->fetchAll(PDO::FETCH_OBJ);
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => $response
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al consultar la base de datos: ' . $e->getMessage(),
        'data' => []
    ]);
}