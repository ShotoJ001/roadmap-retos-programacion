<?php include '../conexion.php';

// Consulta con LEFT JOIN para cruzar el id_grupo de alumnos con el nombre/grupo de la tabla grupos
$consulta = "SELECT a.*, g.grupo AS clave_grupo, g.Nombre AS nombre_grupo 
             FROM alumnos a 
             LEFT JOIN grupos g ON a.id_grupo = g.id_grupo 
             WHERE a.estatus = 'Activo' OR a.estatus IS NULL 
             ORDER BY a.id";

$alumnos = mysqli_query($conexion, $consulta);
if (!$alumnos) { die("❌ Error en la consulta: " . mysqli_error($conexion)); }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Procesos — Alumnos</title>
<style>
body{font-family:Arial;margin:20px;background:#fff}
h2{color:#0066cc;font-size:22px}
table{border-collapse:collapse;width:100%;background:#fff;margin-top:15px}
th{background:#0066cc;color:#fff;padding:10px;text-align:left}
td{border:1px solid #ddd;padding:10px;text-align:center}
a{text-decoration:none}
.icon-agregar{background:#28a745;color:#fff;padding:6px 10px;border-radius:4px;font-weight:bold;display:inline-block;width:24px;text-align:center}
.icon-editar{background:#007bff;color:#fff;padding:6px 10px;border-radius:4px;font-weight:bold;display:inline-block;width:24px;text-align:center}
.icon-eliminar{background:#dc3545;color:#fff;padding:6px 10px;border-radius:4px;font-weight:bold;display:inline-block;width:24px;text-align:center}
a:hover{opacity:0.8}
</style>
</head>
<body>

<h2>Procesos — Alumnos</h2>

<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Apellido Paterno</th>
<th>Apellido Materno</th>
<th>Domicilio</th>
<th>Correo</th>
<th>Teléfono</th>
<th>Grupo</th>
<th>Acciones</th>
</tr>

<?php while ($fila = mysqli_fetch_assoc($alumnos)): ?>
<tr>
<td><?= $fila['id'] ?></td>
<td><?= $fila['nombre'] ?></td>
<td><?= $fila['apaterno'] ?></td>
<td><?= $fila['amaterno'] ?? '' ?></td>
<td><?= $fila['dom'] ?? '' ?></td>
<td><?= $fila['mail'] ?? '' ?></td>
<td><?= $fila['tel'] ?? '' ?></td>
<td><?= $fila['clave_grupo'] ?? 'Sin Grupo' ?></td>
<td>
  <a href="../registro/alumnos.php" class="icon-agregar" title="Agregar / Dar de Alta">+</a>
  <a href="../modificacion/alumnos.php?id=<?= $fila['id'] ?>" class="icon-editar" title="Editar">✏️</a>
  <a href="../baja/alumnos.php?id=<?= $fila['id'] ?>" class="icon-eliminar" title="Dar de Baja" onclick="return confirm('¿Dar de baja?')">🗑️</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<div style="margin:20px 0">
  <a href="../registro/alumnos.php">📝 Registro</a> |
  <a href="../reportes/alumnos.php">📄 Reporte</a> |
  <a href="../baja/alumnos.php">🗑️ Baja</a> |
  <a href="../index.php">🏠 Inicio</a>
  <br><br>
  <a href="../registro/alumnos.php" style="background:#28a745; color:white; padding:8px 16px; text-decoration:none; border-radius:4px; font-weight:bold;">+ Nuevo Alumno</a>
</div>

</body>
</html>