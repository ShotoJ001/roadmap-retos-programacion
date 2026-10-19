<?php include '../conexion.php';
// CREAR
if (isset($_POST['crear'])) {
    $sql = "INSERT INTO materias VALUES(NULL, '{$_POST['descripcion']}', '{$_POST['id_prof']}')";
    mysqli_query($conexion, $sql);
    header("Location: crudmaterias.php"); exit;
}
// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE materias SET descripcion='{$_POST['descripcion']}', id_prof='{$_POST['id_prof']}' WHERE id_mat=$id";
    mysqli_query($conexion, $sql);
    header("Location: crudmaterias.php"); exit;
}
// ELIMINAR
if (isset($_GET['eliminar'])) {
    mysqli_query($conexion, "DELETE FROM materias WHERE id_mat=".(int)$_GET['eliminar']);
    header("Location: crudmaterias.php"); exit;
}
$editar = isset($_GET['editar']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM materias WHERE id_mat=".(int)$_GET['editar'])) : null;
$materias = mysqli_query($conexion, "SELECT m.*, CONCAT(p.apaterno_prof, ' ', p.amaterno_prof, ', ', p.nom_prof) AS profesor FROM materias m LEFT JOIN profesores p ON m.id_prof = p.id_prof ORDER BY descripcion");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>CRUD Materias</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#34495e}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}.btn{padding:10px 20px;border:none;border-radius:4px;cursor:pointer;color:#fff}.crear{background:#27ae60}.act{background:#f39c12}.eli{background:#e74c3c}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#34495e;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{text-decoration:none;margin:0 5px}</style></head>
<body>
<h2>🔧 CRUD — Materias</h2>
<form method='post'>
<h3><?=$editar?'✏️ Editar':'➕ Nueva'?></h3>
<?php if ($editar): ?><input type='hidden' name='id' value='<?=$editar['id_mat']?>'><?php endif; ?>
Nombre de la Materia: <input type='text' name='descripcion' value='<?=$editar['descripcion']??''?>' required>
Profesor Asignado: <select name='id_prof' required>
<option value=''>-- Selecciona --</option>
<?php $p = mysqli_query($conexion, "SELECT * FROM profesores ORDER BY apaterno_prof");
while ($opt = mysqli_fetch_assoc($p)) {
    $sel = isset($editar['id_prof']) && $opt['id_prof'] == $editar['id_prof'] ? "selected" : "";
    echo "<option value='{$opt['id_prof']}' $sel>{$opt['apaterno_prof']} {$opt['amaterno_prof']}, {$opt['nom_prof']}</option>";
} ?>
</select>
<button type='submit' name='<?=$editar?"actualizar":"crear"?>' class="btn <?=$editar?"act":"crear"?>">
<?=$editar?"💾 Actualizar":"➕ Crear"?>
</button>
<?php if ($editar): ?><a href='crudmaterias.php'>Cancelar</a><?php endif; ?>
</form>
<table>
<tr><th>ID</th><th>Materia</th><th>Profesor</th><th>Acciones</th></tr>
<?php while ($m = mysqli_fetch_assoc($materias)): ?>
<tr>
<td><?=$m['id_mat']?></td>
<td><?=$m['descripcion']?></td>
<td><?=$m['profesor']?></td>
<td>
<a href='?editar=<?=$m['id_mat']?>'>✏️ Editar</a>
<a href='?eliminar=<?=$m['id_mat']?>' onclick="return confirm('¿Eliminar esta materia?')" class='eli'>🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>