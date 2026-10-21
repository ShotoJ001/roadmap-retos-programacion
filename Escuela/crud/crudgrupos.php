<?php include '../conexion.php';
// CREAR
if (isset($_POST['crear'])) {
    $sql = "INSERT INTO grupos VALUES(NULL, '{$_POST['grupo']}', '{$_POST['matricula']}', '{$_POST['carrera']}', '{$_POST['semestre']}', '{$_POST['estatus_grupo']}')";
    mysqli_query($conexion, $sql);
    header("Location: crudgrupos.php"); exit;
}
// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE grupos SET grupo='{$_POST['grupo']}', matricula='{$_POST['matricula']}', carrera='{$_POST['carrera']}', semestre='{$_POST['semestre']}', estatus_grupo='{$_POST['estatus_grupo']}' WHERE id_grupo=$id";
    mysqli_query($conexion, $sql);
    header("Location: crudgrupos.php"); exit;
}
// ELIMINAR
if (isset($_GET['eliminar'])) {
    mysqli_query($conexion, "DELETE FROM grupos WHERE id_grupo=".(int)$_GET['eliminar']);
    header("Location: crudgrupos.php"); exit;
}
$editar = isset($_GET['editar']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM grupos WHERE id_grupo=".(int)$_GET['editar'])) : null;
$grupos = mysqli_query($conexion, "SELECT * FROM grupos ORDER BY grupo");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>CRUD Grupos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#34495e}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}.btn{padding:10px 20px;border:none;border-radius:4px;cursor:pointer;color:#fff}.crear{background:#27ae60}.act{background:#f39c12}.eli{background:#e74c3c}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#34495e;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{text-decoration:none;margin:0 5px}</style></head>
<body>
<h2>🔧 CRUD — Grupos</h2>
<form method='post'>
<h3><?=$editar?'✏️ Editar':'➕ Nuevo'?></h3>
<?php if ($editar): ?><input type='hidden' name='id' value='<?=$editar['id_grupo']?>'><?php endif; ?>
Nombre del Grupo: <input type='text' name='grupo' value='<?=$editar['grupo']??''?>' required>
Matrícula: <input type='text' name='matricula' value='<?=$editar['matricula']??''?>' required>
Carrera: <input type='text' name='carrera' value='<?=$editar['carrera']??''?>' required>
Semestre: <input type='text' name='semestre' value='<?=$editar['semestre']??''?>' required>
Estatus: <select name='estatus_grupo'>
<option value='Activo' <?=isset($editar['estatus_grupo']) && $editar['estatus_grupo']=='Activo'?'selected':''?>>Activo</option>
<option value='Inactivo' <?=isset($editar['estatus_grupo']) && $editar['estatus_grupo']=='Inactivo'?'selected':''?>>Inactivo</option>
</select>
<button type='submit' name='<?=$editar?"actualizar":"crear"?>' class="btn <?=$editar?"act":"crear"?>">
<?=$editar?"💾 Actualizar":"➕ Crear"?>
</button>
<?php if ($editar): ?><a href='crudgrupos.php'>Cancelar</a><?php endif; ?>
</form>
<table>
<tr><th>ID</th><th>Grupo</th><th>Carrera</th><th>Semestre</th><th>Estatus</th><th>Acciones</th></tr>
<?php while ($g = mysqli_fetch_assoc($grupos)): ?>
<tr>
<td><?=$g['id_grupo']?></td>
<td><?=$g['grupo']?></td>
<td><?=$g['carrera']?></td>
<td><?=$g['semestre']?></td>
<td><?=$g['estatus_grupo']?></td>
<td>
<a href='?editar=<?=$g['id_grupo']?>'>✏️ Editar</a>
<a href='?eliminar=<?=$g['id_grupo']?>' onclick="return confirm('¿Eliminar este grupo?')" class='eli'>🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>