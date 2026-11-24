<?php
require_once __DIR__ . "/../config/conexion.php";

$alerta = "";
$edicion = null;

if (isset($_POST['guardar'])) {
    $id_alumno   = (int)$_POST['id_alumno'];
    $id_materia  = (int)$_POST['id_materia'];
    $id_profesor = (int)$_POST['id_profesor'];

    $existe = $conexion->query("SELECT id FROM asignaciones WHERE id_materia = $id_materia AND id_alumno = $id_alumno");
    if ($existe && $existe->num_rows > 0) {
        $alerta = '<div class="alert alert-warning" role="alert">El alumno ya tiene asignada esta materia.</div>';
    } else {
        $conexion->query("INSERT INTO asignaciones (id_materia, id_alumno, id_profesor) VALUES ($id_materia, $id_alumno, $id_profesor)");
        $alerta = '<div class="alert alert-success" role="alert">Asignación guardada.</div>';
    }
}

if (isset($_POST['modificar_guardar'])) {
    $id          = (int)$_POST['id'];
    $id_alumno   = (int)$_POST['id_alumno'];
    $id_materia  = (int)$_POST['id_materia'];
    $id_profesor = (int)$_POST['id_profesor'];

    $conexion->query("UPDATE asignaciones SET id_materia = $id_materia, id_alumno = $id_alumno, id_profesor = $id_profesor WHERE id = $id");
    header("Location: asignacion_materia.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conexion->query("DELETE FROM asignaciones WHERE id = $id");
    header("Location: asignacion_materia.php");
    exit;
}

if (isset($_GET['modificar'])) {
    $id = (int)$_GET['modificar'];
    $res = $conexion->query("SELECT * FROM asignaciones WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $edicion = $res->fetch_assoc();
    }
}

$alumnos    = $conexion->query("SELECT id, matricula, nombre, apaterno FROM alumnos WHERE estatus = 'Activo' ORDER BY nombre ASC");
$materias   = $conexion->query("SELECT id, clave_mat, nombre_mat FROM materias WHERE estatus = 'Activo' ORDER BY clave_mat ASC");
$profesores = $conexion->query("SELECT id, nombre, apaterno FROM profesores WHERE estatus = 'Activo' ORDER BY nombre ASC");

$asignaciones = $conexion->query("SELECT asg.id, m.clave_mat, m.nombre_mat,
                                   CONCAT(a.nombre, ' ', a.apaterno) AS alumno,
                                   CONCAT(p.nombre, ' ', p.apaterno) AS docente
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

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= $edicion ? 'Modificar Asignación' : 'Asignación de Materias' ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <?php if ($edicion): ?>
                    <input type="hidden" name="id" value="<?= (int)$edicion['id'] ?>">
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Alumno</label>
                    <select name="id_alumno" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <?php while ($a = $alumnos->fetch_assoc()): ?>
                            <?php $sel = ($edicion && (int)$edicion['id_alumno'] === (int)$a['id']) ? 'selected' : ''; ?>
                            <option value="<?= (int)$a['id'] ?>" <?= $sel ?>>
                                <?= htmlspecialchars($a['matricula'] . ' - ' . $a['nombre'] . ' ' . $a['apaterno']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Materia</label>
                    <select name="id_materia" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <?php while ($m = $materias->fetch_assoc()): ?>
                            <?php $sel = ($edicion && (int)$edicion['id_materia'] === (int)$m['id']) ? 'selected' : ''; ?>
                            <option value="<?= (int)$m['id'] ?>" <?= $sel ?>>
                                <?= htmlspecialchars($m['clave_mat'] . ' - ' . $m['nombre_mat']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Profesor</label>
                    <select name="id_profesor" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <?php while ($p = $profesores->fetch_assoc()): ?>
                            <?php $sel = ($edicion && (int)$edicion['id_profesor'] === (int)$p['id']) ? 'selected' : ''; ?>
                            <option value="<?= (int)$p['id'] ?>" <?= $sel ?>>
                                <?= htmlspecialchars($p['nombre'] . ' ' . $p['apaterno']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-12">
                    <?php if ($edicion): ?>
                        <button type="submit" name="modificar_guardar" class="btn btn-primary btn-sm">Guardar Cambios</button>
                        <a href="asignacion_materia.php" class="btn btn-outline-secondary btn-sm">Cancelar</a>
                    <?php else: ?>
                        <button type="submit" name="guardar" class="btn btn-success btn-sm">Guardar Asignación</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Cargas Académicas Asignadas</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Materia</th>
                        <th>Alumno</th>
                        <th>Docente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = $asignaciones->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($r['clave_mat']) ?></strong> - <?= htmlspecialchars($r['nombre_mat']) ?></td>
                        <td><?= htmlspecialchars($r['alumno']) ?></td>
                        <td><?= htmlspecialchars($r['docente']) ?></td>
                        <td>
                            <a href="?modificar=<?= (int)$r['id'] ?>" class="btn btn-outline-primary btn-sm">Modificar</a>
                            <a href="?eliminar=<?= (int)$r['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar esta asignación?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>