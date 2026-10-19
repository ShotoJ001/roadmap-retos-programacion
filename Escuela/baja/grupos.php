<?php 
include '../conexion.php';

// Si llega un ID desde Procesos, cambiamos su estatus a Inactivo (Baja lógica)
if (isset($_GET['id']) && !isset($_GET['accion'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "UPDATE grupos SET estatus_grupo='Inactivo' WHERE id_grupo=$id");
    header("Location: grupos.php");
    exit;
}

// Acción para Dar de Alta (Reactivar y regresarlo a Procesos)
if (isset($_GET['accion']) && $_GET['accion'] == 'dar_alta') {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "UPDATE grupos SET estatus_grupo='Activo' WHERE id_grupo=$id");
    header("Location: grupos.php");
    exit;
}

// Acción para Eliminar Definitivamente de la Base de Datos
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar_definitivo') {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "DELETE FROM grupos WHERE id_grupo=$id");
    header("Location: grupos.php");
    exit;
}

// Consulta para mostrar únicamente los grupos que están Inactivos (dados de baja)
$grupos_baja = mysqli_query($conexion, "SELECT * FROM grupos WHERE estatus_grupo='Inactivo' ORDER BY id_grupo");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='UTF-8'>
<title>Registro de Grupos Dados de Baja</title>
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

<h2>📁 Registro de Grupos Dados de Baja</h2>

<div class="tabla-contenedor">
<table>
<thead>
<tr>
  <th>ID Baja</th>
  <th>Nombre</th>
  <th>Grupo</th>
  <th>Matrícula</th>
  <th>Carrera</th>
  <th>Semestre</th>
  <th>Estatus</th>
  <th>Fecha de Baja</th>
  <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($grupos_baja) == 0): ?>
<tr><td colspan="9" style="text-align:center; padding: 20px;">No hay grupos dados de baja</td></tr>
<?php endif; ?>
<?php while ($fila = mysqli_fetch_assoc($grupos_baja)): ?>
<tr>
  <td><?= $fila['id_grupo'] ?></td>
  <td><?= $fila['Nombre'] ?></td>
  <td><?= $fila['grupo'] ?></td>
  <td><?= $fila['matricula'] ?></td>
  <td><?= $fila['carrera'] ?></td>
  <td><?= $fila['semestre'] ?></td>
  <td><span class="estatus-inactivo">Inactivo</span></td>
  <td><?= date('Y-m-d H:i:s') ?></td>
  <td>
    <a href="grupos.php?accion=dar_alta&id=<?= $fila['id_grupo'] ?>" class="btn-alta" title="Dar de Alta">✔</a>
    <a href="grupos.php?accion=eliminar_definitivo&id=<?= $fila['id_grupo'] ?>" class="btn-eliminar" title="Eliminar Definitivamente" onclick="return confirm('¿Estás seguro de eliminar permanentemente este grupo?')">🗑️</a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<div class="enlaces">
  <a href="../procesos/grupos.php">Procesos</a> | <a href="../index.php">🏠 Inicio</a>
</div>

</body>
</html>