<?php
require_once __DIR__ . "/../config/conexion.php";
$id_alumno = (int)($_GET['id_alumno'] ?? 0);
$alumnos = $conexion->query("SELECT * FROM alumnos WHERE estatus='Activo'");
$lista = $id_alumno > 0 ? $conexion->query("SELECT m.clave_mat, m.nombre_mat, m.creditos, CONCAT(p.nombre,' ',p.apaterno) AS docente FROM asignaciones asg INNER JOIN materias m ON asg.id_materia=m.id INNER JOIN profesores p ON asg.id_profesor=p.id WHERE asg.id_alumno=$id_alumno") : null;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Materias por Alumno</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white"><h5 class="mb-0">📊 Reporte: Materias por Alumno</h5></div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-9"><select name="id_alumno" class="form-select" required><option value="">Selecciona alumno...</option>
                    <?php while ($a = $alumnos->fetch_assoc()): ?><option value="<?= $a['id'] ?>" <?= $id_alumno==$a['id']?'selected':'' ?>><?= htmlspecialchars($a['matricula'].' - '.$a['nombre'].' '.$a['apaterno']) ?></option><?php endwhile; ?>
                </select></div>
                <div class="col-md-3"><button class="btn btn-dark w-100">Consultar</button></div>
            </form>
            <?php if ($lista): ?>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm mb-3">🖨️ Imprimir</button>
                <table class="table table-bordered">
                    <thead class="table-dark"><tr><th>Clave</th><th>Materia</th><th>Créditos</th><th>Docente</th></tr></thead>
                    <tbody>
                        <?php while ($r = $lista->fetch_assoc()): ?>
                        <tr><td><?= htmlspecialchars($r['clave_mat']) ?></td><td><?= htmlspecialchars($r['nombre_mat']) ?></td><td><?= $r['creditos'] ?></td><td><?= htmlspecialchars($r['docente']) ?></td></tr>
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