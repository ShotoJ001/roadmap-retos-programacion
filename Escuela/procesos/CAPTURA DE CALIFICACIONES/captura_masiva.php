<?php include '../../conexion.php';
$mensaje = "";
if ($_POST) {
  $id_grupo = (int)$_POST['id_grupo'];
  $id_mat = (int)$_POST['id_mat'];
  $id_unidad = (int)$_POST['id_unidad'];
  $id_ciclo = (int)$_POST['id_ciclo'];
  $calif = (float)$_POST['calificacion'];
  
  $alumnos = mysqli_query($conexion, "SELECT id FROM alumnos WHERE id_grupo=$id_grupo");
  $ok = true;
  while ($a = mysqli_fetch_assoc($alumnos)) {
    $sql = "INSERT INTO calificaciones (id_alumno, id_mat, id_unidad, id_ciclo, calificacion)
            VALUES ({$a['id']}, $id_mat, $id_unidad, $id_ciclo, $calif)
            ON DUPLICATE KEY UPDATE calificacion=$calif";
    if (!mysqli_query($conexion, $sql)) {
      $ok = false; $mensaje = "❌ Error: " . mysqli_error($conexion); break;
    }
  }
  if ($ok) $mensaje = "✅ Calificación asignada a todos los alumnos del grupo";
}
$lista = mysqli_query($conexion, "SELECT g.grupo, m.descripcion AS materia, u.descripcion AS unidad,
          COUNT(DISTINCT c.id_alumno) AS total, AVG(c.calificacion) AS promedio
          FROM calificaciones c
          JOIN alumnos a ON c.id_alumno=a.id
          JOIN grupos g ON a.id_grupo=g.id_grupo
          JOIN materias m ON c.id_mat=m.id_mat
          JOIN unidades u ON c.id_unidad=u.id_unidad
          GROUP BY g.id_grupo, c.id_mat, c.id_unidad, c.id_ciclo
          ORDER BY g.grupo, m.descripcion");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'>
<title>Captura Masiva de Calificaciones</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}select,input{width:100%;padding:8px;margin:5px 0 12px;border:1px solid #ddd;border-radius:4px}button{background:#e67e22;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#e67e22;color:#fff;padding:10px}td{border:1px solid #ddd;padding:10px}.ok{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}.err{background:#f8d7da;color:#721c24;padding:10px;border-radius:4px;margin:10px 0}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📝 Captura Masiva por Grupo</h2>
<?php if($mensaje): ?><div class="<?=str_starts_with($mensaje,'✅')?'ok':'err'?>"><?=$mensaje?></div><?php endif; ?>
<form method='post'>
Grupo:
<select name='id_grupo' required>
<option value=''>-- Selecciona --</option>
<?php $g=mysqli_query($conexion,"SELECT * FROM grupos ORDER BY grupo");
while($opt=mysqli_fetch_assoc($g)) echo "<option value='{$opt['id_grupo']}'>{$opt['grupo']} - {$opt['carrera']}</option>"; ?>
</select>
Materia:
<select name='id_mat' required>
<option value=''>-- Selecciona --</option>
<?php $m=mysqli_query($conexion,"SELECT * FROM materias ORDER BY descripcion");
while($opt=mysqli_fetch_assoc($m)) echo "<option value='{$opt['id_mat']}'>{$opt['descripcion']}</option>"; ?>
</select>
Unidad:
<select name='id_unidad' required>
<option value=''>-- Selecciona --</option>
<?php $u=mysqli_query($conexion,"SELECT * FROM unidades");
while($opt=mysqli_fetch_assoc($u)) echo "<option value='{$opt['id_unidad']}'>{$opt['descripcion']}</option>"; ?>
</select>
Ciclo Escolar:
<select name='id_ciclo' required>
<option value=''>-- Selecciona --</option>
<?php $c=mysqli_query($conexion,"SELECT * FROM ciclos ORDER BY nombre_ciclo");
while($opt=mysqli_fetch_assoc($c)) echo "<option value='{$opt['id_ciclo']}'>{$opt['nombre_ciclo']}</option>"; ?>
</select>
Calificación para todos:
<input type='number' step='0.01' min='0' max='10' name='calificacion' required>
<button type='submit'>💾 Asignar a Todo el Grupo</button>
</form>
<h3>Resumen por Grupo</h3>
<table>
<tr><th>Grupo</th><th>Materia</th><th>Unidad</th><th>Alumnos Evaluados</th><th>Promedio</th></tr>
<?php while($r=mysqli_fetch_assoc($lista)): ?>
<tr>
<td><?=$r['grupo']?></td>
<td><?=$r['materia']?></td>
<td><?=$r['unidad']?></td>
<td><?=$r['total']?></td>
<td><strong><?=number_format($r['promedio'],2)?></strong></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>