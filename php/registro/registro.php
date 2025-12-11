<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../conexionBD.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre      = trim($_POST["nombre"] ?? '');
    $correo      = trim($_POST["correo"] ?? ($_POST["email"] ?? ''));
    $usuario     = trim($_POST["usuario"] ?? '');
    $contrasenna = trim($_POST["contrasenna"] ?? ($_POST["contrasena"] ?? ''));
    $confirmar   = trim($_POST["confirmar"] ?? ($_POST["confirm_contrasena"] ?? ''));
    $fecha       = trim($_POST["fecha_nacimiento"] ?? ($_POST["fechaNac"] ?? ''));
    $genero      = trim($_POST["genero"] ?? '');

    if ($nombre === '' || $correo === '' || $usuario === '' || $contrasenna === '' || $confirmar === '') {
        echo "error: complete todos los campos obligatorios";
        exit;
    }

    if ($contrasenna !== $confirmar) {
        echo "error: las contraseñas no coinciden";
        exit;
    }

    $contrasennaHash = password_hash($contrasenna, PASSWORD_DEFAULT);

    $conexion = abrirConexion();

    $sql = "INSERT INTO usuarios (nombre, correo, usuario, contrasenna, fecha_nacimiento, genero)
            VALUES (?, ?, ?, ?, ?, ?);";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        echo "error: no se pudo preparar la consulta";
        cerrarConexion($conexion);
        exit;
    }

    $stmt->bind_param(
        "ssssss",
        $nombre,
        $correo,
        $usuario,
        $contrasennaHash,
        $fecha,
        $genero
    );

    try {

        if ($stmt->execute()) {
            echo "ok";
        }

    } catch (mysqli_sql_exception $e) {

        if ($e->getCode() == 1062) {

            if (str_contains($e->getMessage(), "'usuario'")) {
                echo "error: el nombre de usuario ya existe";
            }
            elseif (str_contains($e->getMessage(), "'correo'")) {
                echo "error: el correo ya está registrado";
            }
            else {
                echo "error: datos duplicados";
            }

        } else {
            echo "error: " . $e->getMessage();
        }
    }

    $stmt->close();
    cerrarConexion($conexion);
}
?>
