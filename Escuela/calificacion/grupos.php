<?php include '../conexion.php';
$mensaje = "";
if ($_POST) {
    $id_grupo = (int)$_POST['id_grupo'];
    $id_mat = (int)$_POST['id_mat'];
    $id_ciclo = (int)$_POST['id_ciclo'];
    $calif = (float)$_POST['calificacion'];
    
    // Primero obtenemos todos los alumnos del grupo para asignar la calificación
    $sql_alumnos = "SELECT id FROM alumnos WHERE id_grupo = $id_grupo";
    $res_alumnos = mysqli_query($conexion, $sql_alumnos);
    
    $ok = true;
    while ($alumno = mysqli_fetch_assoc($res_alumnos)) {
        $sql = "INSERT INTO calificaciones (id_alumno, id_mat, id_ciclo, calificacion) 
                VALUES ({$alumno['id']}, $id_mat, $id_ciclo, $calif)
                ON DUPLICATE KEY UPDATE calificacion = $calif";
        if (!mysqli_query($conexion, $sql)) {
            $ok = false;
            $mensaje = "❌ Error: " . mysqli_error($conexion);
            break;
        }
    }
    
    if ($ok) {
        $mensaje = "✅ Calificación asignada a todos los alumnos del grupo correctamente";
    }
}

$lista = mysqli_query($conexion, "SELECT c.*, g.grupo, COUNT(DISTINCT c.id_alumno) AS total_alumnos, 
                                         m.descripcion AS materia, cic.nombre_ciclo, AVG(c.calificacion) AS promedio_grupo
                                  FROM calificaciones c 
                                  JOIN alumnos a ON c.id_alumno = a.id 
                                  JOIN grupos g ON a.id_grupo = g.id_grupo
                                  JOIN materias m ON c.id_mat = m.id_mat 
                                  JOIN ciclos cic ON c.id_ciclo = cic.id_ciclo 
                                  GROUP BY g.id_grupo, c.id_mat, c.id_ciclo
                                  ORDER BY g.grupo, m.descripcion");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Calificaciones por Grupo</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#f39c12}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}select,input{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{background:#f39c12;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#f39c12;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}.msg{padding:10px;border-radius:4px;margin:10px 0;font-weight:bold}.ok{background:#d4edda;color:#155724}.err{background:#f8d7da;color:#721c24}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📝 Calificaciones por Grupo</h2>
<?php if ($mensaje): ?><div class="msg <?=strpos($mensaje,'✅')===0?'ok':'err'?>"><?=$mensaje?></div><?php endif; ?>
<form method='post'>
Grupo: <select name='id_grupo' required>
<option value=''>-- Selecciona --</option>
<?php $res = mysqli_query($conexion, "SELECT * FROM grupos ORDER BY grupo");
while ($g = mysqli_fetch_assoc($res)) echo "<option value='{$g['id_grupo']}'>{$g['grupo']} - {$g['carrera']}</option>"; ?>
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
Calificación para todos: <input type='number' step='0.01' min='0' max='10' name='calificacion' required placeholder='Ej: 8.5'>
<button type='submit'>💾 Asignar a todo el Grupo</button>
</form>
<h3>Resumen por Grupo</h3>
<table>
<tr><th>Grupo</th><th>Materia</th><th>Ciclo</th><th>Alumnos Evaluados</th><th>Promedio del Grupo</th></tr>
<?php while ($r = mysqli_fetch_assoc($lista)): ?>
<tr>
<td><?=$r['grupo']?></td>
<td><?=$r['materia']?></td>
<td><?=$r['nombre_ciclo']?></td>
<td><?=$r['total_alumnos']?></td>
<td><strong><?=number_format($r['promedio_grupo'], 2)?></strong></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>