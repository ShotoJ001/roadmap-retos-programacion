<?php include '../conexion.php';
$mensaje = "";

// Lógica para eliminar la unidad si se recibe el parámetro 'eliminar'
if (isset($_GET['eliminar'])) {
    $id_eliminar = (int)$_GET['eliminar'];
    $sql_del = "DELETE FROM unidades WHERE id_unidad = $id_eliminar";
    $mensaje = mysqli_query($conexion, $sql_del)
        ? "✅ Unidad eliminada correctamente"
        : "❌ Error al eliminar: " . mysqli_error($conexion);
}

// Lógica para registrar una nueva unidad
if ($_POST && isset($_POST['descripcion'])) {
  $descripcion = trim($_POST['descripcion']);
  $sql = "INSERT INTO unidades (descripcion) VALUES ('$descripcion')";
  $mensaje = mysqli_query($conexion, $sql)
    ? "✅ Unidad registrada"
    : "❌ Error: " . mysqli_error($conexion);
}

$unidades = mysqli_query($conexion, "SELECT * FROM unidades ORDER BY id_unidad");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Registro de Unidades</title>
<style>
body{font-family:Arial;margin:30px;background:#f8f9fa}
form{max-width:500px;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc}
input{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}
button{padding:10px 20px;background:#00bcd4;color:#fff;border:none;border-radius:5px;cursor:pointer}
a{color:#2980b9;text-decoration:none;display:inline-block;margin-top:15px}
p{padding:10px;border-radius:4px;font-weight:bold}
.ok{background:#d4edda;color:#155724}
.err{background:#f8d7da;color:#721c24}
table{border-collapse:collapse;width:100%;background:#fff;margin-top:20px}
th{background:#00bcd4;color:#fff;padding:10px;text-align:left}
td{border:1px solid #ddd;padding:10px}
.btn-eliminar{background:#e74c3c;color:#fff;padding:6px 10px;border-radius:4px;text-decoration:none;font-weight:bold;display:inline-block;text-align:center;}
.btn-eliminar:hover{opacity:0.8}
</style>
</head>
<body>

<h2>📓 Registro de Unidades</h2>

<?php if($mensaje): ?>
    <p class="<?=str_starts_with($mensaje,'✅')?'ok':'err'?>"><?=$mensaje?></p>
<?php endif; ?>

<form method='post'>
Descripción de la Unidad:
<input type='text' name='descripcion' required placeholder="Ej: Unidad 1 — Fundamentos">
<button type='submit'>Guardar Unidad</button>
</form>

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
        <a href="unidades.php?eliminar=<?=$u['id_unidad']?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar esta unidad?')" title="Eliminar">🗑️</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<a href='../index.php'>← Volver al Inicio</a>

</body>
</html>