<?php include '../conexion.php';
if ($_POST) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE profesores SET nom_prof='{$_POST['nom_prof']}', apaterno_prof='{$_POST['apaterno_prof']}', amaterno_prof='{$_POST['amaterno_prof']}', dom_prof='{$_POST['dom_prof']}', mail_prof='{$_POST['mail_prof']}', tel_prof='{$_POST['tel_prof']}', estatus_prof='{$_POST['estatus_prof']}' WHERE id_prof=$id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: profesores.php?msg=ok"); exit;
    }
}
$editar = isset($_GET['id']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM profesores WHERE id_prof=".(int)$_GET['id'])) : null;
$profesores = mysqli_query($conexion, "SELECT * FROM profesores ORDER BY apaterno_prof");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Modificar Profesores</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#e91e63}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px;max-width:500px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{background:#e91e63;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#e91e63;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#e91e63;text-decoration:none;font-weight:bold}.msg{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}</style></head>
<body>
<h2>✏️ Modificación de Profesores</h2>
<?php if (isset($_GET['msg'])) echo "<div class='msg'>✅ Datos actualizados correctamente</div>"; ?>
<?php if (!$editar): ?>
<p>Selecciona el profesor a modificar:</p>
<table>
<tr><th>Nombre Completo</th><th>Correo</th><th>Estatus</th><th>Acción</th></tr>
<?php while ($p = mysqli_fetch_assoc($profesores)): ?>
<tr>
<td><?=$p['apaterno_prof']?> <?=$p['amaterno_prof']?>, <?=$p['nom_prof']?></td>
<td><?=$p['mail_prof']?></td>
<td><?=$p['estatus_prof']?></td>
<td><a href='?id=<?=$p['id_prof']?>'>✏️ Modificar</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<form method='post'>
<input type='hidden' name='id' value='<?=$editar['id_prof']?>'>
Nombre(s): <input type='text' name='nom_prof' value='<?=$editar['nom_prof']?>' required>
Apellido Paterno: <input type='text' name='apaterno_prof' value='<?=$editar['apaterno_prof']?>' required>
Apellido Materno: <input type='text' name='amaterno_prof' value='<?=$editar['amaterno_prof']?>'>
Domicilio: <input type='text' name='dom_prof' value='<?=$editar['dom_prof']?>'>
Correo: <input type='email' name='mail_prof' value='<?=$editar['mail_prof']?>'>
Teléfono: <input type='text' name='tel_prof' value='<?=$editar['tel_prof']?>'>
Estatus: <select name='estatus_prof'>
<option value='Activo' <?=$editar['estatus_prof']=='Activo'?'selected':''?>>Activo</option>
<option value='Inactivo' <?=$editar['estatus_prof']=='Inactivo'?'selected':''?>>Inactivo</option>
</select>
<button type='submit'>💾 Guardar Cambios</button>
<a href='profesores.php'>Cancelar</a>
</form>
<?php endif; ?>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>