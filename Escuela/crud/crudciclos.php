<?php include '../conexion.php';
if (isset($_POST['crear'])) {
    $sql = "INSERT INTO ciclos VALUES(NULL, '{$_POST['nombre_ciclo']}', '{$_POST['fecha_inicio']}', '{$_POST['fecha_fin']}', '{$_POST['estatus_ciclo']}')";
    mysqli_query($conexion, $sql); header("Location: crudciclos.php"); exit;
}
if (isset($_POST['actualizar'])) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE ciclos SET nombre_ciclo='{$_POST['nombre_ciclo']}', fecha_inicio='{$_POST['fecha_inicio']}', fecha_fin='{$_POST['fecha_fin']}', estatus_ciclo='{$_POST['estatus_ciclo']}' WHERE id_ciclo=$id";
    mysqli_query($conexion, $sql); header("Location: crudciclos.php"); exit;
}
if (isset($_GET['eliminar'])) {
    mysqli_query($conexion, "DELETE FROM ciclos WHERE id_ciclo=".(int)$_GET['eliminar']);
    header("Location: crudciclos.php"); exit;
}
$editar = isset($_GET['editar']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM ciclos WHERE id_ciclo=".(int)$_GET['editar'])) : null;
$ciclos = mysqli_query($conexion, "SELECT * FROM ciclos ORDER BY nombre_ciclo");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>CRUD Ciclos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#34495e}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}.btn{padding:10px 20px;border:none;border-radius:4px;cursor:pointer;color:#fff}.crear{background:#27ae60}.act{background:#f39c12}.eli{background:#e74c3c}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#34495e;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{text-decoration:none;margin:0 5px}</style></head>
<body>
<h2>🔧 CRUD — Ciclos Escolares</h2>
<form method='post'>
<h3><?=$editar?'✏️ Editar':'➕ Nuevo'?></h3>
<?php if ($editar): ?><input type='hidden' name='id' value='<?=$editar['id_ciclo']?>'><?php endif; ?>
Nombre del Ciclo: <input type='text' name='nombre_ciclo' value='<?=$editar['nombre_ciclo']??''?>' required>
Fecha de Inicio: <input type='date' name='fecha_inicio' value='<?=$editar['fecha_inicio']??''?>' required>
Fecha de Fin: <input type='date' name='fecha_fin' value='<?=$editar['fecha_fin']??''?>' required>
Estatus: <select name='estatus_ciclo'>
<option>Activo</option><option>Inactivo</option>
</select>
<button type='submit' name='<?=$editar?"actualizar":"crear"?>' class="btn <?=$editar?"act":"crear"?>">
<?=$editar?"💾 Actualizar":"➕ Crear"?>
</button>
<?php if ($editar): ?><a href='crudciclos.php'>Cancelar</a><?php endif; ?>
</form>

<table>
<tr><th>ID</th><th>Ciclo</th><th>Inicio</th><th>Fin</th><th>Estatus</th><th>Acciones</th></tr>
<?php while ($c = mysqli_fetch_assoc($ciclos)): ?>
<tr>
<td><?=$c['id_ciclo']?></td>
<td><?=$c['nombre_ciclo']?></td>
<td><?=$c['fecha_inicio']?></td>
<td><?=$c['fecha_fin']?></td>
<td><?=$c['estatus_ciclo']?></td>
<td>
<a href='?editar=<?=$c['id_ciclo']?>'>✏️ Editar</a>
<a href='?eliminar=<?=$c['id_ciclo']?>' onclick="return confirm('¿Eliminar?')" class='eli'>🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>