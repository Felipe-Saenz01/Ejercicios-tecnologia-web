<?php
header('Content-Type: application/json; charset=utf-8');
include './conexion.php';

$empresas = 'SELECT id, nombre FROM empresas';
$personas = 'SELECT id, nombre FROM personas';

try {
    $consultaPersonas = $db->prepare($personas);
    $consultaPersonas->execute();
    $personasResponse = $consultaPersonas->fetchAll(PDO::FETCH_OBJ);

    $consultaEmpresas = $db->prepare($empresas);
    $consultaEmpresas->execute();
    $empresasResponse = $consultaEmpresas->fetchAll(PDO::FETCH_OBJ);
    echo json_encode([
        'success' => true,
        'message' => 'Registros encontrados',
        'personas' => $personasResponse,
        'empresas' => $empresasResponse,
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al consultar la base de datos: ' . $e->getMessage(),
        'persoas' => [],
        'empresas' => [],
    ]);
}
