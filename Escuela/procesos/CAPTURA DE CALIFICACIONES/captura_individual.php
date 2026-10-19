<?php 
include '../../conexion.php';
$mensaje = "";

if ($_POST) {
    $id_alumno = (int)$_POST['id_alumno'];
    $id_mat = (int)$_POST['id_mat'];
    $id_unidad = (int)$_POST['id_unidad'];
    $id_ciclo = (int)$_POST['id_ciclo'];
    $calif = (float)$_POST['calificacion'];
    
    $sql = "INSERT INTO calificaciones (id_alumno, id_mat, id_unidad, id_ciclo, calificacion)
            VALUES ($id_alumno, $id_mat, $id_unidad, $id_ciclo, $calif)
            ON DUPLICATE KEY UPDATE calificacion=$calif";
    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "✅ Calificación guardada";
    } else {
        $mensaje = "❌ Error guardando: " . mysqli_error($conexion);
    }
}

// ✅ CORREGIDO: c.id_unidad en lugar de c.unidad
$lista = mysqli_query($conexion, "
    SELECT c.*, 
           CONCAT(a.apaterno, ' ', a.amaterno, ', ', a.nombre) AS alumno,
           m.descripcion AS materia, 
           u.descripcion AS unidad, 
           cic.nombre_ciclo
    FROM calificaciones c
    JOIN alumnos a      ON c.id_alumno = a.id
    JOIN materias m     ON c.id_mat    = m.id_mat
    JOIN unidades u     ON c.id_unidad = u.id_unidad
    JOIN ciclos cic     ON c.id_ciclo  = cic.id_ciclo
    ORDER BY alumno, materia, unidad
");

if (!$lista) {
    $mensaje = "❌ Error en consulta: " . mysqli_error($conexion);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Captura Individual de Calificaciones</title>
<style>
body{font-family:Arial;margin:20px;background:#f8f9fa}
form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}
select,input{width:100%;padding:8px;margin:5px 0 12px;border:1px solid #ddd;border-radius:4px}
button{background:#16a085;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}
table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}
th{background:#16a085;color:#fff;padding:10px}
td{border:1px solid #ddd;padding:10px}
.ok{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}
.err{background:#f8d7da;color:#721c24;padding:10px;border-radius:4px;margin:10px 0}
a{color:#2980b9;text-decoration:none}
</style>
</head>
<body>
<h2>📝 Captura Individual de Calificaciones</h2>
<?php if ($mensaje): ?>
    <div class="<?= str_starts_with($mensaje,'✅') ? 'ok' : 'err' ?>">
        <?= $mensaje ?>
    </div>
<?php endif; ?>
<form method='post'>
    <label>Alumno:</label>
    <select name='id_alumno' required>
        <option value=''>-- Selecciona --</option>
        <?php
        $a = mysqli_query($conexion, "SELECT * FROM alumnos ORDER BY apaterno");
        while ($opt = mysqli_fetch_assoc($a)) {
            echo "<option value='{$opt['id']}'>{$opt['apaterno']} {$opt['amaterno']}, {$opt['nombre']}</option>";
        }
        ?>
    </select>

    <label>Materia:</label>
    <select name='id_mat' required>
        <option value=''>-- Selecciona --</option>
        <?php
        $m = mysqli_query($conexion, "SELECT * FROM materias ORDER BY descripcion");
        while ($opt = mysqli_fetch_assoc($m)) {
            echo "<option value='{$opt['id_mat']}'>{$opt['descripcion']}</option>";
        }
        ?>
    </select>

    <label>Unidad:</label>
    <select name='id_unidad' required>
        <option value=''>-- Selecciona --</option>
        <?php
        $u = mysqli_query($conexion, "SELECT * FROM unidades");
        while ($opt = mysqli_fetch_assoc($u)) {
            echo "<option value='{$opt['id_unidad']}'>{$opt['descripcion']}</option>";
        }
        ?>
    </select>

    <label>Ciclo Escolar:</label>
    <select name='id_ciclo' required>
        <option value=''>-- Selecciona --</option>
        <?php
        $c = mysqli_query($conexion, "SELECT * FROM ciclos ORDER BY nombre_ciclo");
        while ($opt = mysqli_fetch_assoc($c)) {
            echo "<option value='{$opt['id_ciclo']}'>{$opt['nombre_ciclo']}</option>";
        }
        ?>
    </select>

    <label>Calificación (0-10):</label>
    <input type='number' step='0.01' min='0' max='10' name='calificacion' required>

    <button type='submit'>💾 Guardar Calificación</button>
</form>

<h3>Historial de Calificaciones</h3>
<table>
<tr>
    <th>Alumno</th>
    <th>Materia</th>
    <th>Unidad</th>
    <th>Ciclo</th>
    <th>Calificación</th>
</tr>
<?php
if ($lista && mysqli_num_rows($lista) > 0) {
    while ($r = mysqli_fetch_assoc($lista)) {
        echo "<tr>
            <td>{$r['alumno']}</td>
            <td>{$r['materia']}</td>
            <td>{$r['unidad']}</td>
            <td>{$r['nombre_ciclo']}</td>
            <td><strong>{$r['calificacion']}</strong></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align:center;color:#7f8c8d'>No hay calificaciones registradas</td></tr>";
}
?>
</table>

<a href='../calificaciones.php'>← Volver a Gestión de Calificaciones</a>
</body>
</html>