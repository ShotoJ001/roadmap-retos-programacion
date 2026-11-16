<?php
require_once __DIR__ . "/../config/conexion.php";
$alerta = "";

if (isset($_POST['inscribir'])) {
    $id_grupo = (int)$_POST['id_grupo'];
    $id_alumno = (int)$_POST['id_alumno'];
    $check = $conexion->query("SELECT id FROM inscripciones WHERE id_grupo=$id_grupo AND id_alumno=$id_alumno");
    if ($check->num_rows > 0) {
        $alerta = '<div class="alert alert-warning">⚠️ El alumno ya está inscrito en ese grupo.</div>';
    } else {
        $conexion->query("INSERT INTO inscripciones (id_grupo, id_alumno, estatus) VALUES ($id_grupo, $id_alumno, 'Activo')");
        $alerta = '<div class="alert alert-success">✅ Alumno inscrito al grupo.</div>';
    }
}

$grupos = $conexion->query("SELECT * FROM grupos WHERE estatus='Activo'");
$alumnos = $conexion->query("SELECT * FROM alumnos WHERE estatus='Activo'");
$inscritos = $conexion->query("SELECT i.id, g.clave_grupo, g.nombre_grupo, a.matricula, CONCAT(a.nombre,' ',a.apaterno,' ',a.amaterno) AS alumno
                               FROM inscripciones i
                               INNER JOIN grupos g ON i.id_grupo = g.id
                               INNER JOIN alumnos a ON i.id_alumno = a.id
                               ORDER BY i.id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción a Grupos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <?= $alerta ?>
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-primary text-white"><h5 class="mb-0">⚙️ Inscripción de Alumnos a Grupos</h5></div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-5"><label class="form-label">Grupo</label>
                    <select name="id_grupo" class="form-select" required>
                        <option value="">Selecciona grupo...</option>
                        <?php while ($g = $grupos->fetch_assoc()): ?>
                            <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['clave_grupo'] . ' - ' . $g['nombre_grupo']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-5"><label class="form-label">Alumno</label>
                    <select name="id_alumno" class="form-select" required>
                        <option value="">Selecciona alumno...</option>
                        <?php while ($a = $alumnos->fetch_assoc()): ?>
                            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['matricula'] . ' - ' . $a['nombre'] . ' ' . $a['apaterno']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end"><button type="submit" name="inscribir" class="btn btn-success btn-sm w-100">Inscribir</button></div>
            </form>
        </div>
    </div>
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white"><h5 class="mb-0">📋 Alumnos Inscritos</h5></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light"><tr><th>Grupo</th><th>Matrícula</th><th>Alumno</th></tr></thead>
                <tbody>
                    <?php while ($r = $inscritos->fetch_assoc()): ?>
                    <tr><td><strong><?= htmlspecialchars($r['clave_grupo']) ?></strong> - <?= htmlspecialchars($r['nombre_grupo']) ?></td><td><?= htmlspecialchars($r['matricula']) ?></td><td><?= htmlspecialchars($r['alumno']) ?></td></tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>