<?php
require_once __DIR__ . "/../config/conexion.php";
$alerta = "";

if (isset($_POST['asignar'])) {
    $id_materia = (int)$_POST['id_materia'];
    $id_alumno = (int)$_POST['id_alumno'];
    $id_profesor = (int)$_POST['id_profesor'];
    $check = $conexion->query("SELECT id FROM asignaciones WHERE id_materia=$id_materia AND id_alumno=$id_alumno");
    if ($check->num_rows > 0) {
        $alerta = '<div class="alert alert-warning">⚠️ El alumno ya tiene asignada esta materia.</div>';
    } else {
        $conexion->query("INSERT INTO asignaciones (id_materia, id_alumno, id_profesor) VALUES ($id_materia, $id_alumno, $id_profesor)");
        $alerta = '<div class="alert alert-success">✅ Materia asignada correctamente.</div>';
    }
}

$materias = $conexion->query("SELECT * FROM materias WHERE estatus='Activo'");
$alumnos = $conexion->query("SELECT * FROM alumnos WHERE estatus='Activo'");
$profesores = $conexion->query("SELECT * FROM profesores WHERE estatus='Activo'");
$lista = $conexion->query("SELECT asg.id, m.clave_mat, m.nombre_mat, CONCAT(a.nombre,' ',a.apaterno) AS alumno, CONCAT(p.nombre,' ',p.apaterno) AS profesor
                           FROM asignaciones asg
                           INNER JOIN materias m ON asg.id_materia = m.id
                           INNER JOIN alumnos a ON asg.id_alumno = a.id
                           INNER JOIN profesores p ON asg.id_profesor = p.id
                           ORDER BY asg.id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignación de Materias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <?= $alerta ?>
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-primary text-white"><h5 class="mb-0">⚙️ Asignación de Materias</h5></div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-4"><label class="form-label">Alumno</label>
                    <select name="id_alumno" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <?php while ($a = $alumnos->fetch_assoc()): ?><option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['matricula'].' - '.$a['nombre'].' '.$a['apaterno']) ?></option><?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Materia</label>
                    <select name="id_materia" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <?php while ($m = $materias->fetch_assoc()): ?><option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['clave_mat'].' - '.$m['nombre_mat']) ?></option><?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Profesor</label>
                    <select name="id_profesor" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <?php while ($p = $profesores->fetch_assoc()): ?><option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre'].' '.$p['apaterno']) ?></option><?php endwhile; ?>
                    </select>
                </div>
                <div class="col-12"><button type="submit" name="asignar" class="btn btn-success btn-sm">💾 Guardar Asignación</button></div>
            </form>
        </div>
    </div>
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white"><h5 class="mb-0">📋 Cargas Académicas Asignadas</h5></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light"><tr><th>Materia</th><th>Alumno</th><th>Docente</th></tr></thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr><td><strong><?= htmlspecialchars($r['clave_mat']) ?></strong> - <?= htmlspecialchars($r['nombre_mat']) ?></td><td><?= htmlspecialchars($r['alumno']) ?></td><td><?= htmlspecialchars($r['profesor']) ?></td></tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>