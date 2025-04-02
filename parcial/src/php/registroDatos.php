<?php
include './conexion.php';


$tabla = $_POST['tabla'] ?? '';

switch ($tabla) {
    case 'personas':
        $sql = "INSERT INTO personas (cedula, nombre, correo) VALUES (?, ?, ?)";
        $params = [$_POST['cedula'], $_POST['nombre'], $_POST['correo']];
        break;

    case 'empresas':

        $sql = "INSERT INTO empresas (nit, nombre, correo) VALUES (?, ?, ?)";
        $params = [$_POST['nit'], $_POST['nombre'], $_POST['correo']];
        break;

    case 'contratos':

        $sql = "INSERT INTO contrato (persona_id, empresa_id, fecha) VALUES (?, ?, NOW())";
        $params = [$_POST['persona_id'], $_POST['empresa_id']];
        break;
}

try {
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    echo json_encode([
        'success' => true,
        'message' => 'Registro guardado correctamente.'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar: ' . $e->getMessage()
    ]);
}
