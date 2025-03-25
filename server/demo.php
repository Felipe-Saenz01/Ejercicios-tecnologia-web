<?php
// print_r($_POST);

$info_email = "test@test.com";
$info_password = "password";

if ($_POST['email'] == $info_email && $_POST['password'] == $info_password) {
    // echo "Información de inicio de sesión correcta";
    echo json_encode(['success' => true]);
} else {
    // echo "Información de inicio de sesión incorrecta";
    echo json_encode(['success' => false]);
}
?> 

