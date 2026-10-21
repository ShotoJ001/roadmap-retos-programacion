<?php include '../conexion.php';

// Filtramos estricto para que SOLO muestre los activos y oculte de inmediato los dados de baja ('Inactivo')
$materias = mysqli_query($conexion, "SELECT m.*, CONCAT(p.nom_prof, ' ', p.apaterno_prof) AS profesor 
                                     FROM materias m 
                                     LEFT JOIN profesores p ON m.id_prof = p.id_prof 
                                     WHERE m.estatus = 'Activo' OR m.estatus IS NULL OR m.estatus = ''
                                     ORDER BY m.id_mat");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Procesos — Materias</title>
<style>
body{font-family:Arial;margin:20px;background:#fff}
h2{color:#5b21b6;font-size:22px}
table{border-collapse:collapse;width:100%;background:#fff;margin-top:15px}
th{background:#5b21b6;color:#fff;padding:10px;text-align:left}
td{border:1px solid #ddd;padding:10px;text-align:center}
a{text-decoration:none}
.icon-agregar{background:#28a745;color:#fff;padding:6px 10px;border-radius:4px;font-weight:bold;display:inline-block;width:24px;text-align:center}
.icon-editar{background:#007bff;color:#fff;padding:6px 10px;border-radius:4px;font-weight:bold;display:inline-block;width:24px;text-align:center}
.icon-eliminar{background:#dc3545;color:#fff;padding:6px 10px;border-radius:4px;font-weight:bold;display:inline-block;width:24px;text-align:center}
a:hover{opacity:0.8}
.mensaje{background:#dcfce7;color:#166534;padding:10px;border-radius:4px;margin:15px 0}
</style>
</head>
<body>

<h2>📋 Procesos — Materias</h2>

<?php if (isset($_GET['msg'])): ?>
<div class="mensaje">
    <?= $_GET['msg'] == 'editado' ? '✅ Materia actualizada' : '' ?>
    <?= $_GET['msg'] == 'baja' ? '✅ Materia dada de baja' : '' ?>
</div>
<?php endif; ?>

<table>
<tr>
<th>ID</th>
<th>Descripción</th>
<th>Clave</th>
<th>Créditos</th>
<th>Profesor</th>
<th>Acciones</th>
</tr>

<?php while ($fila = mysqli_fetch_assoc($materias)): ?>
<?php 
// Si el registro actual ya fue marcado como Inactivo, nos saltamos su fila para no dibujarla en Procesos
if (isset($fila['estatus']) && $fila['estatus'] == 'Inactivo') continue; 
?>
<tr>
<td><?= $fila['id_mat'] ?></td>
<td><?= $fila['descripcion'] ?></td>
<td><?= $fila['clave_mat'] ?></td>
<td><?= $fila['creditos'] ?></td>
<td><?= $fila['profesor'] ?? 'Sin asignar' ?></td>
<td>
  <a href="../registro/materias.php" class="icon-agregar" title="Agregar">+</a>
  <a href="../modificacion/materias.php?id=<?= $fila['id_mat'] ?>" class="icon-editar" title="Editar">✏️</a>
  <a href="../baja/materias.php?id=<?= $fila['id_mat'] ?>" class="icon-eliminar" title="Dar de Baja" onclick="return confirm('¿Dar de baja esta materia?')">🗑️</a>
</td>
</tr>
<?php endwhile; ?>

</table>

<div style="margin:20px 0">
  <a href="../registro/materias.php">📝 Registro</a> |
  <a href="../reportes/materias.php">📄 Reporte</a> |
  <a href="../baja/materias.php">🗑️ Baja</a> |
  <a href="../index.php">🏠 Inicio</a>
  <br><br>
  <a href="../registro/materias.php" style="background:#28a745; color:white; padding:8px 16px; text-decoration:none; border-radius:4px; font-weight:bold;">+ Nueva Materia</a>
</div>

</body>
</html>