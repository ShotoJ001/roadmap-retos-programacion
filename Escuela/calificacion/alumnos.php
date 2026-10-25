<?php include '../conexion.php';
$mensaje = "";
if ($_POST) {
    $id_alumno = (int)$_POST['id_alumno'];
    $id_mat = (int)$_POST['id_mat'];
    $id_ciclo = (int)$_POST['id_ciclo'];
    $calif = (float)$_POST['calificacion'];
    
    $sql = "INSERT INTO calificaciones (id_alumno, id_mat, id_ciclo, calificacion) 
            VALUES ($id_alumno, $id_mat, $id_ciclo, $calif)
            ON DUPLICATE KEY UPDATE calificacion = $calif";
    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "✅ Calificación guardada correctamente";
    } else {
        $mensaje = "❌ Error: " . mysqli_error($conexion);
    }
}
$lista = mysqli_query($conexion, "SELECT c.*, CONCAT(a.apaterno,' ',a.amaterno,', ',a.nombre) AS alumno, m.descripcion AS materia, cic.nombre_ciclo 
                                   FROM calificaciones c 
                                   JOIN alumnos a ON c.id_alumno = a.id 
                                   JOIN materias m ON c.id_mat = m.id_mat 
                                   JOIN ciclos cic ON c.id_ciclo = cic.id_ciclo 
                                   ORDER BY alumno, materia");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Calificaciones</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#f39c12}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}select,input{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{background:#f39c12;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#f39c12;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}.msg{padding:10px;border-radius:4px;margin:10px 0;font-weight:bold}.ok{background:#d4edda;color:#155724}.err{background:#f8d7da;color:#721c24}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📝 Registro de Calificaciones</h2>
<?php if ($mensaje): ?><div class="msg <?=strpos($mensaje,'✅')===0?'ok':'err'?>"><?=$mensaje?></div><?php endif; ?>

<form method='post'>
Alumno: <select name='id_alumno' required>
<option value=''>-- Selecciona --</option>
<?php $res = mysqli_query($conexion, "SELECT * FROM alumnos ORDER BY apaterno");
while ($a = mysqli_fetch_assoc($res)) echo "<option value='{$a['id']}'>{$a['apaterno']} {$a['amaterno']}, {$a['nombre']}</option>"; ?>
</select>

Materia: <select name='id_mat' required>
<option value=''>-- Selecciona --</option>
<?php $res = mysqli_query($conexion, "SELECT * FROM materias ORDER BY descripcion");
while ($m = mysqli_fetch_assoc($res)) echo "<option value='{$m['id_mat']}'>{$m['descripcion']}</option>"; ?>
</select>

Ciclo Escolar: <select name='id_ciclo' required>
<option value=''>-- Selecciona --</option>
<?php $res = mysqli_query($conexion, "SELECT * FROM ciclos ORDER BY nombre_ciclo");
while ($c = mysqli_fetch_assoc($res)) echo "<option value='{$c['id_ciclo']}'>{$c['nombre_ciclo']}</option>"; ?>
</select>

Calificación: <input type='number' step='0.01' min='0' max='10' name='calificacion' required placeholder='Ej: 8.5'>
<button type='submit'>💾 Guardar Calificación</button>
</form>

<h3>Lista de Calificaciones</h3>
<table>
<tr><th>Alumno</th><th>Materia</th><th>Ciclo</th><th>Calificación</th></tr>
<?php while ($c = mysqli_fetch_assoc($lista)): ?>
<tr>
<td><?=$c['alumno']?></td>
<td><?=$c['materia']?></td>
<td><?=$c['nombre_ciclo']?></td>
<td><strong><?=$c['calificacion']?></strong></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>