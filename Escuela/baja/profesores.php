<?php 
include '../conexion.php';

// 1. Si llega un ID desde Procesos sin ninguna acción previa, realiza la baja lógica cambiando estatus a Inactivo
if (isset($_GET['id']) && !isset($_GET['accion'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "UPDATE profesores SET estatus='Inactivo' WHERE id_prof=$id");
    header("Location: profesores.php");
    exit;
}

// 2. Acción para Dar de Alta (Reactivar y regresarlo a Procesos)
if (isset($_GET['accion']) && $_GET['accion'] == 'dar_alta') {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "UPDATE profesores SET estatus='Activo' WHERE id_prof=$id");
    header("Location: profesores.php");
    exit;
}

// 3. Acción para Eliminar Definitivamente de la Base de Datos
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar_definitivo') {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "DELETE FROM profesores WHERE id_prof=$id");
    header("Location: profesores.php");
    exit;
}

// Consulta para mostrar únicamente los profesores inactivos (dados de baja)
$profesores_baja = mysqli_query($conexion, "SELECT * FROM profesores WHERE estatus='Inactivo' ORDER BY id_prof");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='UTF-8'>
<title>Registro de Profesores Dados de Baja</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body { background: #fffdf9; padding: 30px; }
h2 { color: #00d8d6; font-size: 26px; margin-bottom: 20px; font-weight: bold; }
.tabla-contenedor { background: #fff3e6; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
table { border-collapse: collapse; width: 100%; text-align: left; }
th { background: #00f0ff; color: #fff; padding: 14px 16px; font-weight: bold; font-size: 15px; }
td { padding: 14px 16px; border-bottom: 1px solid #fbe3d5; color: #555; font-size: 14px; }
.estatus-inactivo { color: #d35400; font-weight: bold; }
.btn-alta { background: #2ecc71; color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-right: 4px; display: inline-block; }
.btn-eliminar { background: #e74c3c; color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block; }
.enlaces { margin-top: 25px; font-size: 15px; }
.enlaces a { color: #00d8d6; text-decoration: none; font-weight: bold; }
</style>
</head>
<body>

<h2>📁 Registro de Profesores Dados de Baja</h2>

<div class="tabla-contenedor">
<table>
<thead>
<tr>
  <th>ID Baja</th>
  <th>Nombre</th>
  <th>Apellido Paterno</th>
  <th>Apellido Materno</th>
  <th>Correo</th>
  <th>Estatus</th>
  <th>Fecha de Baja</th>
  <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($profesores_baja) == 0): ?>
<tr><td colspan="8" style="text-align:center; padding: 20px;">No hay profesores dados de baja</td></tr>
<?php endif; ?>
<?php while ($fila = mysqli_fetch_assoc($profesores_baja)): ?>
<tr>
  <td><?= $fila['id_prof'] ?></td>
  <td><?= $fila['nom_prof'] ?></td>
  <td><?= $fila['apaterno_prof'] ?></td>
  <td><?= $fila['amaterno_prof'] ?></td>
  <td><?= $fila['mail_prof'] ?></td>
  <td><span class="estatus-inactivo">Inactivo</span></td>
  <td><?= date('Y-m-d H:i:s') ?></td>
  <td>
    <a href="profesores.php?accion=dar_alta&id=<?= $fila['id_prof'] ?>" class="btn-alta" title="Dar de Alta">✔</a>
    <a href="profesores.php?accion=eliminar_definitivo&id=<?= $fila['id_prof'] ?>" class="btn-eliminar" title="Eliminar Definitivamente" onclick="return confirm('¿Estás seguro de eliminar permanentemente este profesor?')">🗑️</a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<div class="enlaces">
  <a href="../procesos/profesores.php">Procesos</a> | <a href="../index.php">🏠 Inicio</a>
</div>

</body>
</html>