<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../conexionBD.php';

$response = [
    'status'  => 'error',
    'mensaje' => 'Error inesperado',
    'debug'   => 'inicio'
];

try {

    $raw   = file_get_contents("php://input");
    $datos = json_decode($raw, true);

    if (!$datos) {
        $response['mensaje'] = 'Solicitud inválida';
        $response['debug'] = 'JSON vacío';
        echo json_encode($response);
        exit;
    }

    $usuario    = trim($datos['usuario'] ?? '');
    $contrasenna = trim($datos['contrasenna'] ?? '');

    if ($usuario === '' || $contrasenna === '') {
        $response['mensaje'] = 'Complete todos los campos';
        $response['debug'] = 'faltan datos';
        echo json_encode($response);
        exit;
    }

    $mysqli = abrirConexion();

    $sql = "SELECT id, nombre, usuario, contrasenna, es_admin
            FROM usuarios
            WHERE usuario = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows === 1) {

        $fila = $resultado->fetch_assoc();

        if (password_verify($contrasenna, $fila['contrasenna'])) {

            $_SESSION['id']          = $fila['id'];
            $_SESSION['nombre']      = $fila['nombre'];
            $_SESSION['usuario']     = $fila['usuario'];
            $_SESSION['es_admin']    = (int)$fila['es_admin'];
            $_SESSION['autenticado'] = true;

            $response = [
                'status'  => 'ok',
                'mensaje' => 'Login correcto',
                'debug'   => 'verify-ok'
            ];

        } else {
            $response['mensaje'] = 'Contraseña incorrecta';
            $response['debug']   = 'verify-false';
        }

    } else {
        $response['mensaje'] = 'Usuario no encontrado';
        $response['debug']   = 'no-user';
    }

    $stmt->close();
    cerrarConexion($mysqli);

} catch (Exception $e) {
    $response['mensaje'] = 'Error interno';
    $response['debug']   = $e->getMessage();
}

echo json_encode($response);
exit;
?>
