<?php
require_once __DIR__ . "/../config/conexion.php";
$alerta = "";

if (isset($_POST['inscribir'])) {
    $id_grupo = (int)$_POST['id_grupo'];
    $id_alumno = (int)$_POST['id_alumno'];

    if ($id_grupo > 0 && $id_alumno > 0) {
        $check = $conexion->query("SELECT id FROM inscripciones WHERE id_grupo = $id_grupo AND id_alumno = $id_alumno");
        if ($check && $check->num_rows > 0) {
            $alerta = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                El alumno ya está inscrito en ese grupo.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>';
        } else {
            $conexion->query("INSERT INTO inscripciones (id_grupo, id_alumno, estatus) VALUES ($id_grupo, $id_alumno, 'Activo')");
            $alerta = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Alumno inscrito al grupo correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>';
        }
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $conexion->query("UPDATE inscripciones SET estatus = IF(estatus = 'Activo', 'Inactivo', 'Activo') WHERE id = $id");
    header("Location: inscripcion_grupo.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conexion->query("DELETE FROM inscripciones WHERE id = $id");
    header("Location: inscripcion_grupo.php");
    exit;
}

$grupos = $conexion->query("SELECT * FROM grupos WHERE estatus = 'Activo' ORDER BY clave_grupo ASC");
$alumnos = $conexion->query("SELECT * FROM alumnos WHERE estatus = 'Activo' ORDER BY matricula ASC");
$inscritos = $conexion->query("SELECT i.id, i.estatus, g.clave_grupo, g.nombre_grupo, a.matricula, CONCAT(a.nombre,' ',a.apaterno,' ',a.amaterno) AS alumno
                               FROM inscripciones i
                               INNER JOIN grupos g ON i.id_grupo = g.id
                               INNER JOIN alumnos a ON i.id_alumno = a.id
                               ORDER BY i.id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a Grupos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container py-4">
    <?= $alerta ?>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title mb-0 fw-semibold">
                <i class="bi bi-gear-fill me-2"></i>Inscripción de Alumnos a Grupos
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="id_grupo" class="form-label">Grupo</label>
                    <select id="id_grupo" name="id_grupo" class="form-select" required>
                        <option value="">Selecciona grupo...</option>
                        <?php while ($g = $grupos->fetch_assoc()): ?>
                            <option value="<?= (int)$g['id'] ?>">
                                <?= htmlspecialchars($g['clave_grupo'] . ' - ' . $g['nombre_grupo']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="id_alumno" class="form-label">Alumno</label>
                    <select id="id_alumno" name="id_alumno" class="form-select" required>
                        <option value="">Selecciona alumno...</option>
                        <?php while ($a = $alumnos->fetch_assoc()): ?>
                            <option value="<?= (int)$a['id'] ?>">
                                <?= htmlspecialchars($a['matricula'] . ' - ' . $a['nombre'] . ' ' . $a['apaterno']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="inscribir" class="btn btn-success w-100">
                        Inscribir
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="card-title mb-0 fw-semibold">
                <i class="bi bi-clipboard-check me-2"></i>Alumnos Inscritos
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-3">Grupo</th>
                            <th scope="col">Matrícula</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">Estatus</th>
                            <th scope="col" class="pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($inscritos && $inscritos->num_rows > 0): ?>
                            <?php while ($r = $inscritos->fetch_assoc()): ?>
                            <?php $estaActivo = ($r['estatus'] === 'Activo'); ?>
                            <tr>
                                <td class="ps-3">
                                    <strong><?= htmlspecialchars($r['clave_grupo']) ?></strong> - <?= htmlspecialchars($r['nombre_grupo']) ?>
                                </td>
                                <td><?= htmlspecialchars($r['matricula']) ?></td>
                                <td><?= htmlspecialchars($r['alumno']) ?></td>
                                <td>
                                    <span class="badge rounded-pill <?= $estaActivo ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                        <?= $estaActivo ? 'ALTA' : 'BAJA' ?>
                                    </span>
                                </td>
                                <td class="pe-3">
                                    <div class="d-flex gap-2">
                                        <a href="?toggle=<?= (int)$r['id'] ?>" class="btn btn-outline-secondary btn-sm">
                                            <?= $estaActivo ? 'Dar de baja' : 'Reactivar' ?>
                                        </a>
                                        <a href="?eliminar=<?= (int)$r['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar esta inscripción?');">
                                            Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No hay alumnos inscritos.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>