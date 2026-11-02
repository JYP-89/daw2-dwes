<?php
require_once __DIR__ . '/includes/auth.php';

$_SESSION = [];
// La matriz de sesión queda vacía, así que la autenticación termina.

header('Location: login.php');
exit();
