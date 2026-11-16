<?php
require_once __DIR__ . "/../config/conexion.php";
$id_materia = (int)($_GET['id_materia'] ?? 0);
$id_grupo   = (int)($_GET['id_grupo'] ?? 0);
$materias = $conexion->query("SELECT * FROM materias WHERE estatus='Activo'");
$grupos   = $conexion->query("SELECT * FROM grupos WHERE estatus='Activo'");

$lista = ($id_materia > 0 && $id_grupo > 0) ? $conexion->query("
    SELECT a.matricula, CONCAT(a.nombre,' ',a.apaterno,' ',a.amaterno) AS alumno, u.nombre_unidad, c.calificacion
    FROM inscripciones i
    INNER JOIN alumnos a ON i.id_alumno = a.id
    INNER JOIN calificaciones c ON c.id_alumno = a.id AND c.id_materia = $id_materia
    INNER JOIN unidades u ON c.id_unidad = u.id
    WHERE i.id_grupo = $id_grupo
    ORDER BY a.apaterno, u.id") : null;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Calificaciones por Materia y Grupo</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white"><h5 class="mb-0">📊 Reporte: Calificaciones por Materia y Grupo</h5></div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-5"><select name="id_materia" class="form-select" required><option value="">Selecciona materia...</option>
                    <?php while ($m = $materias->fetch_assoc()): ?><option value="<?= $m['id'] ?>" <?= $id_materia==$m['id']?'selected':'' ?>><?= htmlspecialchars($m['nombre_mat']) ?></option><?php endwhile; ?>
                </select></div>
                <div class="col-md-5"><select name="id_grupo" class="form-select" required><option value="">Selecciona grupo...</option>
                    <?php while ($g = $grupos->fetch_assoc()): ?><option value="<?= $g['id'] ?>" <?= $id_grupo==$g['id']?'selected':'' ?>><?= htmlspecialchars($g['clave_grupo'].' - '.$g['nombre_grupo']) ?></option><?php endwhile; ?>
                </select></div>
                <div class="col-md-2"><button class="btn btn-dark w-100">Consultar</button></div>
            </form>
            <?php if ($lista): ?>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm mb-3">🖨️ Imprimir</button>
                <table class="table table-bordered">
                    <thead class="table-dark"><tr><th>Matrícula</th><th>Alumno</th><th>Unidad</th><th>Calificación</th></tr></thead>
                    <tbody>
                        <?php while ($r = $lista->fetch_assoc()): ?>
                        <tr><td><?= htmlspecialchars($r['matricula']) ?></td><td><?= htmlspecialchars($r['alumno']) ?></td><td><?= htmlspecialchars($r['nombre_unidad']) ?></td><td><strong><?= $r['calificacion'] ?></strong></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>