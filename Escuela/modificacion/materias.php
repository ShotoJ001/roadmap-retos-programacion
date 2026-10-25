<?php include '../conexion.php';
if ($_POST) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE materias SET descripcion='{$_POST['descripcion']}', id_prof='{$_POST['id_prof']}' WHERE id_mat=$id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: materias.php?msg=ok"); exit;
    }
}
$editar = isset($_GET['id']) ? mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM materias WHERE id_mat=".(int)$_GET['id'])) : null;
$materias = mysqli_query($conexion, "SELECT m.*, CONCAT(p.apaterno_prof, ' ', p.amaterno_prof, ', ', p.nom_prof) AS profesor FROM materias m LEFT JOIN profesores p ON m.id_prof = p.id_prof ORDER BY descripcion");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Modificar Materias</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#e91e63}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px;max-width:500px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{background:#e91e63;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#e91e63;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#e91e63;text-decoration:none;font-weight:bold}.msg{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin:10px 0}</style></head>
<body>
<h2>✏️ Modificación de Materias</h2>
<?php if (isset($_GET['msg'])) echo "<div class='msg'>✅ Datos actualizados correctamente</div>"; ?>
<?php if (!$editar): ?>
<p>Selecciona la materia a modificar:</p>
<table>
<tr><th>Materia</th><th>Profesor Asignado</th><th>Acción</th></tr>
<?php while ($m = mysqli_fetch_assoc($materias)): ?>
<tr>
<td><?=$m['descripcion']?></td>
<td><?=$m['profesor']?></td>
<td><a href='?id=<?=$m['id_mat']?>'>✏️ Modificar</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<form method='post'>
<input type='hidden' name='id' value='<?=$editar['id_mat']?>'>
Nombre de la Materia: <input type='text' name='descripcion' value='<?=$editar['descripcion']?>' required>
Profesor Asignado: <select name='id_prof' required>
<option value=''>-- Selecciona --</option>
<?php $p = mysqli_query($conexion, "SELECT * FROM profesores ORDER BY apaterno_prof");
while ($opt = mysqli_fetch_assoc($p)) {
    $sel = $opt['id_prof'] == $editar['id_prof'] ? "selected" : "";
    echo "<option value='{$opt['id_prof']}' $sel>{$opt['apaterno_prof']} {$opt['amaterno_prof']}, {$opt['nom_prof']}</option>";
} ?>
</select>
<button type='submit'>💾 Guardar Cambios</button>
<a href='materias.php'>Cancelar</a>
</form>
<?php endif; ?>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>