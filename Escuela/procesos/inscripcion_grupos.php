<?php include '../conexion.php';
$mensaje = "";
if ($_POST) {
  $id_grupo = (int)$_POST['id_grupo'];
  $id_alumno = (int)$_POST['id_alumno'];
  $sql = "INSERT INTO inscripciones (id_grupo, id_alumno, status_ins)
          VALUES ($id_grupo, $id_alumno, 'ACTA')
          ON DUPLICATE KEY UPDATE status_ins='ACTA'";
  $mensaje = mysqli_query($conexion, $sql)
    ? "✅ Alumno inscrito correctamente"
    : "❌ Error: " . mysqli_error($conexion);
}
$lista = mysqli_query($conexion, "SELECT i.*, a.apaterno, a.amaterno, a.nombre, g.grupo
          FROM inscripciones i
          JOIN alumnos a ON i.id_alumno=a.id
          JOIN grupos g ON i.id_grupo=g.id_grupo
          ORDER BY g.grupo, a.apaterno");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'>
<title>Inscripción a Grupos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}select{width:100%;padding:8px;margin:5px 0 15px;border:1px solid #ddd;border-radius:4px}button{background:#27ae60;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#27ae60;color:#fff;padding:10px}td{border:1px solid #ddd;padding:10px}.ok{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}.err{background:#f8d7da;color:#721c24;padding:10px;border-radius:4px;margin:10px 0}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📝 Inscripción a Grupos</h2>
<?php if($mensaje): ?><div class="<?=str_starts_with($mensaje,'✅')?'ok':'err'?>"><?=$mensaje?></div><?php endif; ?>
<form method='post'>
Grupo:
<select name='id_grupo' required>
<option value=''>-- Selecciona --</option>
<?php $g=mysqli_query($conexion,"SELECT * FROM grupos ORDER BY grupo");
while($opt=mysqli_fetch_assoc($g)) echo "<option value='{$opt['id_grupo']}'>{$opt['grupo']} - {$opt['carrera']}</option>"; ?>
</select>
Alumno:
<select name='id_alumno' required>
<option value=''>-- Selecciona --</option>
<?php $a=mysqli_query($conexion,"SELECT * FROM alumnos ORDER BY apaterno");
while($opt=mysqli_fetch_assoc($a)) echo "<option value='{$opt['id']}'>{$opt['apaterno']} {$opt['amaterno']}, {$opt['nombre']}</option>"; ?>
</select>
<button type='submit'>✅ Inscribir Alumno</button>
</form>
<h3>Lista de Inscritos</h3>
<table>
<tr><th>Grupo</th><th>Alumno</th><th>Estatus</th></tr>
<?php while($r=mysqli_fetch_assoc($lista)): ?>
<tr>
<td><?=$r['grupo']?></td>
<td><?=$r['apaterno']?> <?=$r['amaterno']?>, <?=$r['nombre']?></td>
<td><strong><?=$r['status_ins']?></strong></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>