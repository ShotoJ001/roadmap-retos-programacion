<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "Escuela";
$PUERTO   = 3306;

$conexion = new mysqli($host, $user, $pass, '', $PUERTO);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (!$conexion->select_db($db)) {
    $conexion->query("CREATE DATABASE IF NOT EXISTS `$db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    $conexion->select_db($db);

    $sqlFile = dirname(__DIR__) . "/sql/Escuela.sql";
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        $conexion->multi_query($sql);
        while ($conexion->more_results() && $conexion->next_result());
    }
}
$conexion->set_charset("utf8mb4");

$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$base = preg_replace('#/(crudregistro|formularios|procesos|reportes|navBar|baja)$#', '', $base);
?>