<?php

function abrirConexion()
{

    $host = "localhost";
    $user = "root";
    $passwork = "Vargas2002#";
    $db = "eduforo";

    $mysqli = new mysqli($host, $user, $passwork, $db);

    if ($mysqli->connect_errno) {
        throw new Exception("Error de conexion: " . $mysqli->connect_errno);
    }

    $mysqli->set_charset("utf8mb4");

    return $mysqli;
}

function cerrarConexion($mysqli)
{
    $mysqli->close();
}
