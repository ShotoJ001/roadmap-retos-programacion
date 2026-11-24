<?php
require_once __DIR__ . "/../config/conexion.php";
$alerta = "";
$tab = $_GET['tab'] ?? 'individual';
$id_materia = (int)($_GET['id_materia'] ?? 0);
$id_unidad  = (int)($_GET['id_unidad'] ?? 0);

if (isset($_POST['guardar_individual'])) {
    $id_al  = (int)$_POST['id_alumno'];
    $id_mat = (int)$_POST['id_materia'];
    $id_uni = (int)$_POST['id_unidad'];
    $cal    = (float)$_POST['calificacion'];

    if ($cal >= 0 && $cal <= 10) {
        $check = $conexion->query("SELECT id FROM calificaciones WHERE id_alumno=$id_al AND id_materia=$id_mat AND id_unidad=$id_uni");
        if ($check->num_rows > 0) {
            $conexion->query("UPDATE calificaciones SET calificacion=$cal WHERE id_alumno=$id_al AND id_materia=$id_mat AND id_unidad=$id_uni");
        } else {
            $conexion->query("INSERT INTO calificaciones (id_alumno, id_materia, id_unidad, calificacion) VALUES ($id_al, $id_mat, $id_uni, $cal)");
        }
        $alerta = '<div class="alert alert-success">✅ Calificación guardada/actualizada.</div>';
    }
}

if (isset($_POST['guardar_masivo'])) {
    $id_mat = (int)$_POST['id_materia'];
    $id_uni = (int)$_POST['id_unidad'];
    $count = 0;
    foreach ($_POST['calif'] ?? [] as $id_al => $val) {
        if ($val !== '' && is_numeric($val) && $val >= 0 && $val <= 10) {
            $id_al = (int)$id_al;
            $cal = (float)$val;
            $check = $conexion->query("SELECT id FROM calificaciones WHERE id_alumno=$id_al AND id_materia=$id_mat AND id_unidad=$id_uni");
            if ($check->num_rows > 0) {
                $conexion->query("UPDATE calificaciones SET calificacion=$cal WHERE id_alumno=$id_al AND id_materia=$id_mat AND id_unidad=$id_uni");
            } else {
                $conexion->query("INSERT INTO calificaciones (id_alumno, id_materia, id_unidad, calificacion) VALUES ($id_al, $id_mat, $id_uni, $cal)");
            }
            $count++;
        }
    }
    $alerta = "<div class='alert alert-success'>✅ Se guardaron $count calificaciones.</div>";
}

$alumnos = $conexion->query("SELECT * FROM alumnos WHERE estatus='Activo'");
$materias = $conexion->query("SELECT * FROM materias WHERE estatus='Activo'");
$unidades = $conexion->query("SELECT * FROM unidades WHERE estatus='Activo'");

$filas_masivas = null;
if ($tab === 'masiva' && $id_materia > 0 && $id_unidad > 0) {
    $filas_masivas = $conexion->query("SELECT a.id, a.matricula, CONCAT(a.nombre,' ',a.apaterno,' ',a.amaterno) AS alumno, c.calificacion
                                       FROM asignaciones asg
                                       INNER JOIN alumnos a ON asg.id_alumno = a.id AND a.estatus='Activo'
                                       LEFT JOIN calificaciones c ON c.id_alumno = a.id AND c.id_materia = $id_materia AND c.id_unidad = $id_unidad
                                       WHERE asg.id_materia = $id_materia");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Captura de Calificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <?= $alerta ?>
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white"><h5 class="mb-0"> Captura de Calificaciones</h5></div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item"><a class="nav-link <?= $tab === 'individual' ? 'active fw-bold' : '' ?>" href="?tab=individual">Individual</a></li>
                <li class="nav-item"><a class="nav-link <?= $tab === 'masiva' ? 'active fw-bold' : '' ?>" href="?tab=masiva">Masiva por Materia</a></li>
            </ul>

            <?php if ($tab === 'individual'): ?>
                <form method="POST" class="row g-3">
                    <div class="col-md-4"><label class="form-label">Alumno</label>
                        <select name="id_alumno" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <?php while ($a = $alumnos->fetch_assoc()): ?><option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['matricula'].' - '.$a['nombre'].' '.$a['apaterno']) ?></option><?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3"><label class="form-label">Materia</label>
                        <select name="id_materia" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <?php while ($m = $materias->fetch_assoc()): ?><option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nombre_mat']) ?></option><?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3"><label class="form-label">Unidad</label>
                        <select name="id_unidad" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <?php while ($u = $unidades->fetch_assoc()): ?><option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre_unidad']) ?></option><?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2"><label class="form-label">Calificación</label><input type="number" step="0.1" min="0" max="10" name="calificacion" class="form-control" required></div>
                    <div class="col-12"><button type="submit" name="guardar_individual" class="btn btn-success btn-sm">💾 Guardar Calificación</button></div>
                </form>
            <?php else: ?>
                <form method="GET" class="row g-3 mb-4">
                    <input type="hidden" name="tab" value="masiva">
                    <div class="col-md-5"><label class="form-label">Materia</label>
                        <select name="id_materia" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <?php while ($m = $materias->fetch_assoc()): ?><option value="<?= $m['id'] ?>" <?= $id_materia == $m['id'] ? 'selected' : '' ?>><?= htmlspecialchars($m['nombre_mat']) ?></option><?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-5"><label class="form-label">Unidad</label>
                        <select name="id_unidad" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <?php while ($u = $unidades->fetch_assoc()): ?><option value="<?= $u['id'] ?>" <?= $id_unidad == $u['id'] ? 'selected' : '' ?>><?= htmlspecialchars($u['nombre_unidad']) ?></option><?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end"><button type="submit" class="btn btn-primary btn-sm w-100">Cargar Lista</button></div>
                </form>

                <?php if ($filas_masivas): ?>
                <form method="POST">
                    <input type="hidden" name="id_materia" value="<?= $id_materia ?>">
                    <input type="hidden" name="id_unidad" value="<?= $id_unidad ?>">
                    <div class="mb-3 d-flex justify-content-between">
                        <button type="submit" name="guardar_masivo" class="btn btn-success btn-sm">💾 Guardar Todas</button>
                        <button type="button" onclick="exportarExcel()" class="btn btn-outline-success btn-sm">📊 Exportar Excel</button>
                    </div>
                    <table id="tablaCalif" class="table table-bordered align-middle">
                        <thead class="table-dark"><tr><th>Matrícula</th><th>Alumno</th><th>Capturar / Editar</th><th>Registrada</th></tr></thead>
                        <tbody>
                            <?php while ($f = $filas_masivas->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($f['matricula']) ?></td>
                                <td><?= htmlspecialchars($f['alumno']) ?></td>
                                <td><input type="number" step="0.1" min="0" max="10" name="calif[<?= $f['id'] ?>]" value="<?= $f['calificacion'] ?>" class="form-control form-control-sm"></td>
                                <td><span class="badge bg-secondary"><?= $f['calificacion'] ?? 'Sin captura' ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
function exportarExcel() {
    var html = document.getElementById("tablaCalif").outerHTML;
    var a = document.createElement("a");
    a.href = URL.createObjectURL(new Blob(['\ufeff' + html], { type: 'application/vnd.ms-excel' }));
    a.download = "Calificaciones_Escuela.xls";
    a.click();
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>