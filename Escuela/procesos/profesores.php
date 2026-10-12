<?php include '../conexion.php';
$profesores = mysqli_query($conexion, "SELECT * FROM profesores ORDER BY id_prof");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Procesos — Profesores</title>
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

<h2>Procesos — Profesores</h2>

<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Apellido Paterno</th>
<th>Apellido Materno</th>
<th>Correo</th>
<th>Estatus</th>
<th>Acciones</th>
</tr>

<?php while ($fila = mysqli_fetch_assoc($profesores)): ?>
<tr>
<td><?= $fila['id_prof'] ?></td>
<td><?= $fila['nom_prof'] ?></td>
<td><?= $fila['apaterno_prof'] ?></td>
<td><?= $fila['amaterno_prof'] ?></td>
<td><?= $fila['mail_prof'] ?></td>
<td><?= $fila['estatus_prof'] ?></td>
<td>
  <a href="../registro/profesores.php" class="icon-agregar" title="Agregar / Dar de Alta">+</a>
  <a href="../baja/profesores.php?id=<?= $fila['id_prof'] ?>" class="icon-editar" title="Editar">✏️</a>
  <a href="../baja/profesores.php?id=<?= $fila['id_prof'] ?>" class="icon-eliminar" title="Eliminar / Dar de Baja">🗑️</a>
</td>
</tr>
<?php endwhile; ?>

</table>

<div style="margin:20px 0">
  <a href="../registro/profesores.php">📝 Registro</a> |
  <a href="../reportes/reporte_profesores.php">📄 Reporte</a> |
  <a href="../baja/profesores.php">🗑️ Baja</a> |
  <a href="../index.php">🏠 Inicio</a>
  <br><br>
  <a href="../registro/profesores.php" style="background:#28a745; color:white; padding:8px 16px; text-decoration:none; border-radius:4px; font-weight:bold;">+ Nuevo Profesor</a>
</div>

</body>
</html>