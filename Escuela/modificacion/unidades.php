<?php 
include '../conexion.php';
$mensaje = "";

// Lógica para actualizar la unidad si se envía el formulario
if ($_POST && isset($_POST['id_unidad'], $_POST['descripcion'])) {
    $id_unidad = (int)$_POST['id_unidad'];
    $descripcion = trim($_POST['descripcion']);
    
    $sql = "UPDATE unidades SET descripcion = '$descripcion' WHERE id_unidad = $id_unidad";
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "✅ Unidad actualizada correctamente";
    } else {
        $mensaje = "❌ Error al actualizar: " . mysqli_error($conexion);
    }
}

// Si se pasa un ID por GET para editar
$unidad_editar = null;
if (isset($_GET['editar'])) {
    $id_edit = (int)$_GET['editar'];
    $res = mysqli_query($conexion, "SELECT * FROM unidades WHERE id_unidad = $id_edit");
    $unidad_editar = mysqli_fetch_assoc($res);
}

$unidades = mysqli_query($conexion, "SELECT * FROM unidades ORDER BY id_unidad");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='UTF-8'>
<title>Modificar Unidades</title>
<style>
body{font-family:Arial;margin:30px;background:#f8f9fa}
.contenedor{max-width:700px;margin:0 auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc}
h2{color:#2c3e50;margin-bottom:20px}
input{width:100%;padding:8px;margin:5px 0 15px;border:1px solid #ddd;border-radius:4px}
button{padding:10px 20px;background:#e67e22;color:#fff;border:none;border-radius:5px;cursor:pointer}
table{border-collapse:collapse;width:100%;margin-top:20px}
th{background:#2c3e50;color:#fff;padding:10px;text-align:left}
td{border:1px solid #ddd;padding:10px}
.ok{background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin-bottom:15px}
.err{background:#f8d7da;color:#721c24;padding:10px;border-radius:4px;margin-bottom:15px}
a{color:#2980b9;text-decoration:none}
.btn-editar{background:#2980b9;color:#fff;padding:6px 10px;border-radius:4px;font-weight:bold}
a.volver{display:inline-block;margin-top:20px;background:#2c3e50;color:#fff;padding:10px 20px;border-radius:4px;text-decoration:none}
a.volver:hover{background:#34495e}
</style>
</head>
<body>

<div class="contenedor">
<h2>✏️ Modificar Unidades</h2>

<?php if($mensaje): ?>
    <div class="<?=str_starts_with($mensaje,'✅')?'ok':'err'?>"><?=$mensaje?></div>
<?php endif; ?>

<?php if($unidad_editar): ?>
<form method='post'>
    <input type='hidden' name='id_unidad' value="<?=$unidad_editar['id_unidad']?>">
    <label>Descripción de la Unidad:</label>
    <input type='text' name='descripcion' value="<?=$unidad_editar['descripcion']?>" required>
    <button type='submit'>💾 Guardar Cambios</button>
    <a href="unidades.php" style="margin-left:10px;">Cancelar</a>
</form>
<hr style="margin:20px 0;">
<?php endif; ?>

<h3>Lista de Unidades</h3>
<table>
<tr>
    <th>ID</th>
    <th>Descripción</th>
    <th style="width: 100px; text-align: center;">Acciones</th>
</tr>
<?php while($u = mysqli_fetch_assoc($unidades)): ?>
<tr>
    <td><?=$u['id_unidad']?></td>
    <td><?=$u['descripcion']?></td>
    <td style="text-align: center;">
        <a href="unidades.php?editar=<?=$u['id_unidad']?>" class="btn-editar">Editar</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<a href='../index.php' class="volver">← Volver al Inicio</a>
</div>

</body>
</html>