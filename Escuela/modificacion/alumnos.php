<?php include '../conexion.php';
if ($_POST) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE alumnos SET nombre='{$_POST['nombre']}', apaterno='{$_POST['apaterno']}', amaterno='{$_POST['amaterno']}', dom='{$_POST['dom']}', mail='{$_POST['mail']}', tel='{$_POST['tel']}', id_grupo='{$_POST['id_grupo']}' WHERE id=$id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: alumnos.php?msg=ok"); exit;
    }
}
$editar = isset($_GET['id']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM alumnos WHERE id=".(int)$_GET['id'])) : null;
$alumnos = mysqli_query($conexion, "SELECT a.*, g.grupo FROM alumnos a LEFT JOIN grupos g ON a.id_grupo = g.id_grupo ORDER BY apaterno");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Modificar Alumnos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#e91e63}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px;max-width:500px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{background:#e91e63;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#e91e63;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#e91e63;text-decoration:none;font-weight:bold}.msg{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}</style></head>
<body>
<h2>✏️ Modificación de Alumnos</h2>
<?php if (isset($_GET['msg'])) echo "<div class='msg'>✅ Datos actualizados correctamente</div>"; ?>

<?php if (!$editar): ?>
<p>Selecciona el alumno a modificar:</p>
<table>
<tr><th>Nombre</th><th>Grupo</th><th>Acción</th></tr>
<?php while ($a = mysqli_fetch_assoc($alumnos)): ?>
<tr>
<td><?=$a['apaterno']?> <?=$a['amaterno']?>, <?=$a['nombre']?></td>
<td><?=$a['grupo']?></td>
<td><a href='?id=<?=$a['id']?>'>✏️ Modificar</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<form method='post'>
<input type='hidden' name='id' value='<?=$editar['id']?>'>
Nombre: <input type='text' name='nombre' value='<?=$editar['nombre']?>' required>
Apellido Paterno: <input type='text' name='apaterno' value='<?=$editar['apaterno']?>' required>
Apellido Materno: <input type='text' name='amaterno' value='<?=$editar['amaterno']?>'>
Domicilio: <input type='text' name='dom' value='<?=$editar['dom']?>'>
Correo: <input type='email' name='mail' value='<?=$editar['mail']?>'>
Teléfono: <input type='text' name='tel' value='<?=$editar['tel']?>'>
Grupo: <select name='id_grupo' required>
<?php $g = mysqli_query($conexion, "SELECT * FROM grupos ORDER BY grupo");
while ($opt = mysqli_fetch_assoc($g)) {
    $sel = $opt['id_grupo'] == $editar['id_grupo'] ? "selected" : "";
    echo "<option value='{$opt['id_grupo']}' $sel>{$opt['grupo']}</option>";
} ?>
</select>
<button type='submit'>💾 Guardar Cambios</button>
<a href='alumnos.php'>Cancelar</a>
</form>
<?php endif; ?>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>