<?php include '../conexion.php';
$mensaje = "";
if ($_POST) {
  $id_mat = (int)$_POST['id_mat'];
  $id_alumno = (int)$_POST['id_alumno'];
  $id_prof = (int)$_POST['id_prof'];
  $sql = "INSERT INTO asignacion_materias (id_mat, id_alumno, id_prof)
          VALUES ($id_mat, $id_alumno, $id_prof)
          ON DUPLICATE KEY UPDATE id_prof=$id_prof";
  $mensaje = mysqli_query($conexion, $sql)
    ? "✅ Materia asignada correctamente"
    : "❌ Error: " . mysqli_error($conexion);
}
$lista = mysqli_query($conexion, "SELECT am.*, a.apaterno, a.amaterno, a.nombre,
          m.descripcion AS materia, p.nom_prof, p.apaterno_prof
          FROM asignacion_materias am
          JOIN alumnos a ON am.id_alumno=a.id
          JOIN materias m ON am.id_mat=m.id_mat
          JOIN profesores p ON am.id_prof=p.id_prof
          ORDER BY a.apaterno, m.descripcion");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'>
<title>Asignación de Materias</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}select{width:100%;padding:8px;margin:5px 0 15px;border:1px solid #ddd;border-radius:4px}button{background:#f39c12;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#f39c12;color:#fff;padding:10px}td{border:1px solid #ddd;padding:10px}.ok{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}.err{background:#f8d7da;color:#721c24;padding:10px;border-radius:4px;margin:10px 0}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📚 Asignación de Materias</h2>
<?php if($mensaje): ?><div class="<?=str_starts_with($mensaje,'✅')?'ok':'err'?>"><?=$mensaje?></div><?php endif; ?>
<form method='post'>
Materia:
<select name='id_mat' required>
<option value=''>-- Selecciona --</option>
<?php $m=mysqli_query($conexion,"SELECT * FROM materias ORDER BY descripcion");
while($opt=mysqli_fetch_assoc($m)) echo "<option value='{$opt['id_mat']}'>{$opt['descripcion']}</option>"; ?>
</select>
Alumno:
<select name='id_alumno' required>
<option value=''>-- Selecciona --</option>
<?php $a=mysqli_query($conexion,"SELECT * FROM alumnos ORDER BY apaterno");
while($opt=mysqli_fetch_assoc($a)) echo "<option value='{$opt['id']}'>{$opt['apaterno']} {$opt['amaterno']}, {$opt['nombre']}</option>"; ?>
</select>
Profesor:
<select name='id_prof' required>
<option value=''>-- Selecciona --</option>
<?php $p=mysqli_query($conexion,"SELECT * FROM profesores ORDER BY apaterno_prof");
while($opt=mysqli_fetch_assoc($p)) echo "<option value='{$opt['id_prof']}'>{$opt['apaterno_prof']} {$opt['amaterno_prof']}, {$opt['nom_prof']}</option>"; ?>
</select>
<button type='submit'>💾 Asignar Materia</button>
</form>
<h3>Asignaciones Realizadas</h3>
<table>
<tr><th>Alumno</th><th>Materia</th><th>Profesor</th></tr>
<?php while($r=mysqli_fetch_assoc($lista)): ?>
<tr>
<td><?=$r['apaterno']?> <?=$r['amaterno']?>, <?=$r['nombre']?></td>
<td><?=$r['materia']?></td>
<td><?=$r['apaterno_prof']?>, <?=$r['nom_prof']?></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>