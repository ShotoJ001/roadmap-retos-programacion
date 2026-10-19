<?php include '../conexion.php';
// CREAR
if (isset($_POST['crear'])) {
    $sql = "INSERT INTO profesores VALUES(NULL, '{$_POST['nom_prof']}', '{$_POST['apaterno_prof']}', '{$_POST['amaterno_prof']}', '{$_POST['dom_prof']}', '{$_POST['mail_prof']}', '{$_POST['tel_prof']}', '{$_POST['estatus_prof']}')";
    mysqli_query($conexion, $sql);
    header("Location: crudprofesores.php"); exit;
}
// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE profesores SET nom_prof='{$_POST['nom_prof']}', apaterno_prof='{$_POST['apaterno_prof']}', amaterno_prof='{$_POST['amaterno_prof']}', dom_prof='{$_POST['dom_prof']}', mail_prof='{$_POST['mail_prof']}', tel_prof='{$_POST['tel_prof']}', estatus_prof='{$_POST['estatus_prof']}' WHERE id_prof=$id";
    mysqli_query($conexion, $sql);
    header("Location: crudprofesores.php"); exit;
}
// ELIMINAR
if (isset($_GET['eliminar'])) {
    mysqli_query($conexion, "DELETE FROM profesores WHERE id_prof=".(int)$_GET['eliminar']);
    header("Location: crudprofesores.php"); exit;
}
$editar = isset($_GET['editar']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM profesores WHERE id_prof=".(int)$_GET['editar'])) : null;
$profesores = mysqli_query($conexion, "SELECT * FROM profesores ORDER BY apaterno_prof");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>CRUD Profesores</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#34495e}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}.btn{padding:10px 20px;border:none;border-radius:4px;cursor:pointer;color:#fff}.crear{background:#27ae60}.act{background:#f39c12}.eli{background:#e74c3c}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#34495e;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{text-decoration:none;margin:0 5px}</style></head>
<body>
<h2>🔧 CRUD — Profesores</h2>
<form method='post'>
<h3><?=$editar?'✏️ Editar':'➕ Nuevo'?></h3>
<?php if ($editar): ?><input type='hidden' name='id' value='<?=$editar['id_prof']?>'><?php endif; ?>
Nombre(s): <input type='text' name='nom_prof' value='<?=$editar['nom_prof']??''?>' required>
Apellido Paterno: <input type='text' name='apaterno_prof' value='<?=$editar['apaterno_prof']??''?>' required>
Apellido Materno: <input type='text' name='amaterno_prof' value='<?=$editar['amaterno_prof']??''?>'>
Domicilio: <input type='text' name='dom_prof' value='<?=$editar['dom_prof']??''?>'>
Correo: <input type='email' name='mail_prof' value='<?=$editar['mail_prof']??''?>'>
Teléfono: <input type='text' name='tel_prof' value='<?=$editar['tel_prof']??''?>'>
Estatus: <select name='estatus_prof'>
<option value='Activo' <?=isset($editar['estatus_prof']) && $editar['estatus_prof']=='Activo'?'selected':''?>>Activo</option>
<option value='Inactivo' <?=isset($editar['estatus_prof']) && $editar['estatus_prof']=='Inactivo'?'selected':''?>>Inactivo</option>
</select>
<button type='submit' name='<?=$editar?"actualizar":"crear"?>' class="btn <?=$editar?"act":"crear"?>">
<?=$editar?"💾 Actualizar":"➕ Crear"?>
</button>
<?php if ($editar): ?><a href='crudprofesores.php'>Cancelar</a><?php endif; ?>
</form>
<table>
<tr><th>ID</th><th>Nombre Completo</th><th>Correo</th><th>Teléfono</th><th>Estatus</th><th>Acciones</th></tr>
<?php while ($p = mysqli_fetch_assoc($profesores)): ?>
<tr>
<td><?=$p['id_prof']?></td>
<td><?=$p['apaterno_prof']?> <?=$p['amaterno_prof']?>, <?=$p['nom_prof']?></td>
<td><?=$p['mail_prof']?></td>
<td><?=$p['tel_prof']?></td>
<td><?=$p['estatus_prof']?></td>
<td>
<a href='?editar=<?=$p['id_prof']?>'>✏️ Editar</a>
<a href='?eliminar=<?=$p['id_prof']?>' onclick="return confirm('¿Eliminar este profesor?')" class='eli'>🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>