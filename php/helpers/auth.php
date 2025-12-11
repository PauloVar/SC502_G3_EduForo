<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function usuarioEstaAutenticado()
{
    return isset($_SESSION['id']);
}

function usuarioEsAdmin()
{
    return usuarioEstaAutenticado()
        && !empty($_SESSION['es_admin'])
        && intval($_SESSION['es_admin']) === 1;
}

function obtenerNombreUsuario()
{
    if (!empty($_SESSION['usuario'])) {
        return $_SESSION['usuario'];
    }

    if (!empty($_SESSION['nombre'])) {
        return $_SESSION['nombre'];
    }

    return 'Usuario';
}
