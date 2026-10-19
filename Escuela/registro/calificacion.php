<?php 
include '../conexion.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_alumno = (int)$_POST['id_alumno'];
    $id_mat = (int)$_POST['id_mat'];
    $id_unidad = (int)$_POST['id_unidad'];
    $nombre_ciclo = trim($_POST['nombre_ciclo']); // Ahora se recibe como texto
    $calificacion = (float)$_POST['calificacion'];

    // Verificar si el ciclo ya existe, si no, insertarlo
    $verificar = mysqli_query($conexion, "SELECT id_ciclo FROM ciclos WHERE nombre_ciclo = '$nombre_ciclo' LIMIT 1");
    if (mysqli_num_rows($verificar) > 0) {
        $fila = mysqli_fetch_assoc($verificar);
        $id_ciclo = (int)$fila['id_ciclo'];
    } else {
        // Insertar ciclo nuevo automáticamente
        mysqli_query($conexion, "INSERT INTO ciclos (nombre_ciclo) VALUES ('$nombre_ciclo')");
        $id_ciclo = (int)mysqli_insert_id($conexion);
    }

    $sql = "INSERT INTO calificaciones (id_alumno, id_mat, id_unidad, id_ciclo, calificacion)
            VALUES ($id_alumno, $id_mat, $id_unidad, $id_ciclo, $calificacion)
            ON DUPLICATE KEY UPDATE calificacion = $calificacion";
    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "<div style='background:#d4edda;color:#155724;padding:12px;border-radius:4px;margin:15px 0;font-weight:bold;text-align:center'>✅ Calificación registrada correctamente</div>";
    } else {
        $mensaje = "<div style='background:#f8d7da;color:#721c24;padding:12px;border-radius:4px;margin:15px 0;font-weight:bold;text-align:center'>❌ Error: " . mysqli_error($conexion) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='UTF-8'>
<title>Registro de Calificaciones</title>
<style>
body{font-family:Arial;margin:20px;background:#f8f9fa}
.contenedor{max-width:600px;margin:0 auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
h2{text-align:center;color:#2c3e50;margin-bottom:25px}
label{font-weight:bold;margin:12px 0 5px;display:block;color:#333}
select,input{width:100%;padding:10px;margin-bottom:15px;border:1px solid #ddd;border-radius:4px;font-size:15px}
button{background:#27ae60;color:#fff;border:none;padding:12px;width:100%;border-radius:4px;font-size:16px;cursor:pointer;margin-top:10px}
button:hover{background:#219653}
a{display:inline-block;margin-top:20px;color:#2980b9;text-decoration:none}
.ayuda{font-size:13px;color:#7f8c8d;margin:-10px 0 10px}
</style>
</head>
<body>

<div class="contenedor">
<h2>📝 Registrar Calificación</h2>

<?= $mensaje ?>

<form method='post'>
    <label>Alumno:</label>
    <select name='id_alumno' required>
        <option value=''>-- Selecciona un alumno --</option>
        <?php
        $a = mysqli_query($conexion, "SELECT * FROM alumnos ORDER BY apaterno, amaterno");
        while ($opt = mysqli_fetch_assoc($a)) {
            echo "<option value='{$opt['id']}'>{$opt['apaterno']} {$opt['amaterno']}, {$opt['nombre']}</option>";
        }
        ?>
    </select>

    <label>Materia:</label>
    <select name='id_mat' required>
        <option value=''>-- Selecciona una materia --</option>
        <?php
        $m = mysqli_query($conexion, "SELECT * FROM materias ORDER BY descripcion");
        while ($opt = mysqli_fetch_assoc($m)) {
            echo "<option value='{$opt['id_mat']}'>{$opt['descripcion']}</option>";
        }
        ?>
    </select>

    <label>Unidad:</label>
    <select name='id_unidad' required>
        <option value=''>-- Selecciona una unidad --</option>
        <?php
        $u = mysqli_query($conexion, "SELECT * FROM unidades ORDER BY id_unidad");
        while ($opt = mysqli_fetch_assoc($u)) {
            echo "<option value='{$opt['id_unidad']}'>{$opt['descripcion']}</option>";
        }
        ?>
    </select>

    <label>Ciclo Escolar:</label>
    <input type='text' name='nombre_ciclo' required placeholder='Ej: 2026-2027, Sep-Dic 2026...'>
    <p class="ayuda">✏️ Escribe el nombre del ciclo, se guarda automáticamente</p>

    <label>Calificación (0.00 - 10.00):</label>
    <input type='number' step='0.01' min='0' max='10' name='calificacion' required placeholder='Ej: 8.50'>

    <button type='submit'>💾 Guardar Calificación</button>
</form>

<a href='../index.php'>← Volver al Inicio</a>
</div>

</body>
</html>