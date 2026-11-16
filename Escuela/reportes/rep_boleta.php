<?php
require_once __DIR__ . "/../config/conexion.php";
$id_alumno = (int)($_GET['id_alumno'] ?? 0);
$alumnos = $conexion->query("SELECT * FROM alumnos WHERE estatus='Activo'");
$lista = null;
$promedio = 0;

if ($id_alumno > 0) {
    $lista = $conexion->query("SELECT m.clave_mat, m.nombre_mat, u.nombre_unidad, c.calificacion
                               FROM calificaciones c
                               INNER JOIN materias m ON c.id_materia = m.id
                               INNER JOIN unidades u ON c.id_unidad = u.id
                               WHERE c.id_alumno = $id_alumno
                               ORDER BY m.nombre_mat, u.id");
    $p = $conexion->query("SELECT AVG(calificacion) AS prom FROM calificaciones WHERE id_alumno = $id_alumno")->fetch_assoc();
    $promedio = $p['prom'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Boleta de Calificaciones</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white"><h5 class="mb-0">🎓 Boleta Oficial de Calificaciones</h5></div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-9"><select name="id_alumno" class="form-select" required><option value="">Selecciona alumno...</option>
                    <?php while ($a = $alumnos->fetch_assoc()): ?><option value="<?= $a['id'] ?>" <?= $id_alumno==$a['id']?'selected':'' ?>><?= htmlspecialchars($a['matricula'].' - '.$a['nombre'].' '.$a['apaterno']) ?></option><?php endwhile; ?>
                </select></div>
                <div class="col-md-3"><button class="btn btn-dark w-100">Generar Boleta</button></div>
            </form>
            <?php if ($lista): ?>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm mb-3">🖨️ Imprimir Boleta</button>
                <table class="table table-bordered">
                    <thead class="table-dark"><tr><th>Clave</th><th>Materia</th><th>Unidad</th><th>Calificación</th></tr></thead>
                    <tbody>
                        <?php while ($r = $lista->fetch_assoc()): ?>
                        <tr><td><?= htmlspecialchars($r['clave_mat']) ?></td><td><?= htmlspecialchars($r['nombre_mat']) ?></td><td><?= htmlspecialchars($r['nombre_unidad']) ?></td><td><strong><?= $r['calificacion'] ?></strong></td></tr>
                        <?php endwhile; ?>
                        <tr class="table-primary">
                            <td colspan="3" class="text-end fw-bold">PROMEDIO GENERAL:</td>
                            <td class="fw-bold"><?= number_format($promedio, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>