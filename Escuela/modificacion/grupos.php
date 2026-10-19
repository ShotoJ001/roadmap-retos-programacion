<?php include '../conexion.php';
if ($_POST) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE grupos SET grupo='{$_POST['grupo']}', matricula='{$_POST['matricula']}', carrera='{$_POST['carrera']}', semestre='{$_POST['semestre']}', estatus_grupo='{$_POST['estatus_grupo']}' WHERE id_grupo=$id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: grupos.php?msg=ok"); exit;
    }
}
$editar = isset($_GET['id']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM grupos WHERE id_grupo=".(int)$_GET['id'])) : null;
$grupos = mysqli_query($conexion, "SELECT * FROM grupos ORDER BY grupo");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Modificar Grupos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#e91e63}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px;max-width:500px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{background:#e91e63;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#e91e63;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#e91e63;text-decoration:none;font-weight:bold}.msg{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}</style></head>
<body>
<h2>✏️ Modificación de Grupos</h2>
<?php if (isset($_GET['msg'])) echo "<div class='msg'>✅ Datos actualizados correctamente</div>"; ?>
<?php if (!$editar): ?>
<p>Selecciona el grupo a modificar:</p>
<table>
<tr><th>Grupo</th><th>Carrera</th><th>Semestre</th><th>Acción</th></tr>
<?php while ($g = mysqli_fetch_assoc($grupos)): ?>
<tr>
<td><?=$g['grupo']?></td>
<td><?=$g['carrera']?></td>
<td><?=$g['semestre']?></td>
<td><a href='?id=<?=$g['id_grupo']?>'>✏️ Modificar</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<form method='post'>
<input type='hidden' name='id' value='<?=$editar['id_grupo']?>'>
Nombre del Grupo: <input type='text' name='grupo' value='<?=$editar['grupo']?>' required>
Matrícula: <input type='text' name='matricula' value='<?=$editar['matricula']?>' required>
Carrera: <input type='text' name='carrera' value='<?=$editar['carrera']?>' required>
Semestre: <input type='text' name='semestre' value='<?=$editar['semestre']?>' required>
Estatus: <select name='estatus_grupo'>
<option value='Activo' <?=$editar['estatus_grupo']=='Activo'?'selected':''?>>Activo</option>
<option value='Inactivo' <?=$editar['estatus_grupo']=='Inactivo'?'selected':''?>>Inactivo</option>
</select>
<button type='submit'>💾 Guardar Cambios</button>
<a href='grupos.php'>Cancelar</a>
</form>
<?php endif; ?>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>