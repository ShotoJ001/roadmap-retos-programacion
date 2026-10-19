<?php 
include '../conexion.php';

// 1. Si llega un ID desde Procesos, cambia el estatus a Inactivo (Baja lógica)
if (isset($_GET['id']) && !isset($_GET['accion'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "UPDATE materias SET estatus='Inactivo' WHERE id_mat=$id");
    header("Location: materias.php");
    exit;
}

// 2. Acción para Dar de Alta (Reactivar y regresar a Procesos)
if (isset($_GET['accion']) && $_GET['accion'] == 'dar_alta') {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "UPDATE materias SET estatus='Activo' WHERE id_mat=$id");
    header("Location: materias.php");
    exit;
}

// 3. Acción para Eliminar Definitivamente de la Base de Datos
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar_definitivo') {
    $id = (int)$_GET['id'];
    mysqli_query($conexion, "DELETE FROM materias WHERE id_mat=$id");
    header("Location: materias.php");
    exit;
}

// Consulta para mostrar únicamente las materias inactivas (dadas de baja)
$materias_baja = mysqli_query($conexion, "SELECT m.*, CONCAT(p.nom_prof, ' ', p.apaterno_prof) AS profesor 
                                           FROM materias m 
                                           LEFT JOIN profesores p ON m.id_prof = p.id_prof 
                                           WHERE m.estatus='Inactivo' 
                                           ORDER BY m.id_mat");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='UTF-8'>
<title>Registro de Materias Dadas de Baja</title>
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

<h2>📁 Registro de Materias Dadas de Baja</h2>

<div class="tabla-contenedor">
<table>
<thead>
<tr>
  <th>ID Baja</th>
  <th>Descripción</th>
  <th>Clave</th>
  <th>Créditos</th>
  <th>Profesor</th>
  <th>Estatus</th>
  <th>Fecha de Baja</th>
  <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($materias_baja) == 0): ?>
<tr><td colspan="8" style="text-align:center; padding: 20px;">No hay materias dadas de baja</td></tr>
<?php endif; ?>
<?php while ($fila = mysqli_fetch_assoc($materias_baja)): ?>
<tr>
  <td><?= $fila['id_mat'] ?></td>
  <td><?= $fila['descripcion'] ?></td>
  <td><?= $fila['clave_mat'] ?></td>
  <td><?= $fila['creditos'] ?></td>
  <td><?= $fila['profesor'] ?? 'Sin asignar' ?></td>
  <td><span class="estatus-inactivo">Inactivo</span></td>
  <td><?= date('Y-m-d H:i:s') ?></td>
  <td>
    <a href="materias.php?accion=dar_alta&id=<?= $fila['id_mat'] ?>" class="btn-alta" title="Dar de Alta">✔</a>
    <a href="materias.php?accion=eliminar_definitivo&id=<?= $fila['id_mat'] ?>" class="btn-eliminar" title="Eliminar Definitivamente" onclick="return confirm('¿Estás seguro de eliminar permanentemente esta materia?')">🗑️</a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<div class="enlaces">
  <a href="../procesos/materias.php">Procesos</a> | <a href="../index.php">🏠 Inicio</a>
</div>

</body>
</html>