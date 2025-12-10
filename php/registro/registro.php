<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
const nombre = document.getElementById("nombre_Completo").value.trim();
        const email = document.getElementById("email").value.trim();
        const usuario = document.getElementById("usuario").value.trim();
        const contrasena = document.getElementById("contrasena").value.trim();
        const confirmar = document.getElementById("confirm_contrasena").value.trim();
        const fechaNac = document.getElementById("fechaNac").value;
        const genero = document.querySelector('input[name="genero"]:checked')?.value;*/

include("../conexionBD.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = $_POST["nombre_Completo"] ?? '';
    $email = $_POST["email"] ?? '';
    $usuario = $_POST["usuario"] ?? '';
    $contrasena = $_POST["contrasena"] ?? '';
    $confirmar = $_POST["confirm_contrasena"] ?? '';
    $fechaNac = $_POST["fechaNac"] ?? '';
    $genero = $_POST["genero"] ?? '';

    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    $conexion = abrirConexion();

    $sql = "INSERT INTO usuarios (nombre, correo, usuario, contrasenna, fecha_nacimiento, genero)
    VALUES(?,?,?,?,?,?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $email, $usuario, $contrasenaHash, $fechaNac, $genero);



    if($stmt->execute()){
    echo "ok";
    }else{
        echo "error:".$conexion->error;
        }


    $stmt->close();
    cerrarConexion($conexion);

    
}




?>