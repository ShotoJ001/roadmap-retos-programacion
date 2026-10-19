<?php include '../conexion.php';
// Solo seleccionamos los grupos que estén Activos
$grupos = mysqli_query($conexion, "SELECT * FROM grupos WHERE estatus_grupo = 'Activo' OR estatus_grupo IS NULL ORDER BY id_grupo");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Procesos — Grupos</title>
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

<h2>Procesos — Grupos</h2>

<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Grupo</th>
<th>Matrícula</th>
<th>Carrera</th>
<th>Semestre</th>
<th>Estatus</th>
<th>Acciones</th>
</tr>

<?php while ($fila = mysqli_fetch_assoc($grupos)): ?>
<tr>
<td><?= $fila['id_grupo'] ?></td>
<td><?= $fila['Nombre'] ?></td>
<td><?= $fila['grupo'] ?></td>
<td><?= $fila['matricula'] ?></td>
<td><?= $fila['carrera'] ?></td>
<td><?= $fila['semestre'] ?></td>
<td><?= $fila['estatus_grupo'] ?></td>
<td>
  <a href="../registro/grupos.php" class="icon-agregar" title="Agregar / Dar de Alta">+</a>
  <a href="../baja/grupos.php?id=<?= $fila['id_grupo'] ?>" class="icon-editar" title="Editar">✏️</a>
  <a href="../baja/grupos.php?id=<?= $fila['id_grupo'] ?>" class="icon-eliminar" title="Dar de Baja" onclick="return confirm('¿Dar de baja este grupo?')">🗑️</a>
</td>
</tr>
<?php endwhile; ?>

</table>

<div style="margin:20px 0">
  <a href="../registro/grupos.php">📝 Registro</a> |
  <a href="../reportes/grupos.php">📄 Reporte</a> |
  <a href="../baja/grupos.php">🗑️ Baja</a> |
  <a href="../index.php">🏠 Inicio</a>
  <br><br>
  <a href="../registro/grupos.php" style="background:#28a745; color:white; padding:8px 16px; text-decoration:none; border-radius:4px; font-weight:bold;">+ Nuevo Grupo</a>
</div>

</body>
</html>