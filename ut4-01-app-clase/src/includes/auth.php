<?php

// Inicia la sesión si aún no está activa y protege las páginas que incluyen este archivo.

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit();
}
