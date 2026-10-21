<?php include '../conexion.php';
// CREAR
if (isset($_POST['crear'])) {
    $sql = "INSERT INTO alumnos VALUES(NULL, '{$_POST['nombre']}', '{$_POST['apaterno']}', '{$_POST['amaterno']}', '{$_POST['dom']}', '{$_POST['mail']}', '{$_POST['tel']}', '{$_POST['id_grupo']}')";
    mysqli_query($conexion, $sql);
    header("Location: crudalumnos.php"); exit;
}
// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE alumnos SET nombre='{$_POST['nombre']}', apaterno='{$_POST['apaterno']}', amaterno='{$_POST['amaterno']}', dom='{$_POST['dom']}', mail='{$_POST['mail']}', tel='{$_POST['tel']}', id_grupo='{$_POST['id_grupo']}' WHERE id=$id";
    mysqli_query($conexion, $sql);
    header("Location: crudalumnos.php"); exit;
}
// ELIMINAR
if (isset($_GET['eliminar'])) {
    mysqli_query($conexion, "DELETE FROM alumnos WHERE id=".(int)$_GET['eliminar']);
    header("Location: crudalumnos.php"); exit;
}
$editar = isset($_GET['editar']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM alumnos WHERE id=".(int)$_GET['editar'])) : null;
$alumnos = mysqli_query($conexion, "SELECT a.*, g.grupo FROM alumnos a LEFT JOIN grupos g ON a.id_grupo = g.id_grupo ORDER BY apaterno");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>CRUD Alumnos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#34495e}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}.btn{padding:10px 20px;border:none;border-radius:4px;cursor:pointer;color:#fff}.crear{background:#27ae60}.act{background:#f39c12}.eli{background:#e74c3c}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#34495e;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{text-decoration:none;margin:0 5px}</style></head>
<body>
<h2>🔧 CRUD — Alumnos</h2>

<form method='post'>
<h3><?=$editar?'✏️ Editar':'➕ Nuevo'?></h3>
<?php if ($editar): ?><input type='hidden' name='id' value='<?=$editar['id']?>'><?php endif; ?>
Nombre: <input type='text' name='nombre' value='<?=$editar['nombre']??''?>' required>
Apellido Paterno: <input type='text' name='apaterno' value='<?=$editar['apaterno']??''?>' required>
Apellido Materno: <input type='text' name='amaterno' value='<?=$editar['amaterno']??''?>'>
Domicilio: <input type='text' name='dom' value='<?=$editar['dom']??''?>'>
Correo: <input type='email' name='mail' value='<?=$editar['mail']??''?>'>
Teléfono: <input type='text' name='tel' value='<?=$editar['tel']??''?>'>
Grupo: <select name='id_grupo' required>
<option value=''>-- Selecciona --</option>
<?php $g = mysqli_query($conexion, "SELECT * FROM grupos ORDER BY grupo");
while ($opt = mysqli_fetch_assoc($g)) {
    $sel = isset($editar['id_grupo']) && $opt['id_grupo'] == $editar['id_grupo'] ? "selected" : "";
    echo "<option value='{$opt['id_grupo']}' $sel>{$opt['grupo']}</option>";
} ?>
</select>
<button type='submit' name='<?=$editar?"actualizar":"crear"?>' class="btn <?=$editar?"act":"crear"?>">
<?=$editar?"💾 Actualizar":"➕ Crear"?>
</button>
<?php if ($editar): ?><a href='crudalumnos.php'>Cancelar</a><?php endif; ?>
</form>

<table>
<tr><th>ID</th><th>Nombre</th><th>Grupo</th><th>Acciones</th></tr>
<?php while ($a = mysqli_fetch_assoc($alumnos)): ?>
<tr>
<td><?=$a['id']?></td>
<td><?=$a['apaterno']?> <?=$a['amaterno']?>, <?=$a['nombre']?></td>
<td><?=$a['grupo']?></td>
<td>
<a href='?editar=<?=$a['id']?>'>✏️ Editar</a>
<a href='?eliminar=<?=$a['id']?>' onclick="return confirm('¿Eliminar?')" class='eli'>🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>