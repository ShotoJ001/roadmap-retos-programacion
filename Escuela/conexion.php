<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$base = "Escuela";
$puerto = 3306; // Si usas el estándar cambia a 3306

$conexion = mysqli_connect($servidor, $usuario, $clave, $base, $puerto);

if (!$conexion) {
    die("❌ Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8mb4");
?>
