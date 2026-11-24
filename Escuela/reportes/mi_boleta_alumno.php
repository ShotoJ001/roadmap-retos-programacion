<?php
require_once __DIR__ . "/../config/lib_consulta.php";

// Si usas sesión de alumno, toma $_SESSION['id_alumno']; si no, recibe ?id_alumno=
$idAlumno = (int)($_SESSION['id_alumno'] ?? ($_GET['id_alumno'] ?? 1));

$resumen        = obtenerResumenAlumno($conexion, $idAlumno);
$calificaciones = obtenerCalificacionesAlumno($conexion, $idAlumno);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Calificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @media print {
            body {
                background-color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            nav, .d-print-none {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container py-4">
    <?php if ($resumen): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Alumno (ID #<?= (int)$resumen['id_alumno'] ?>)</small>
                        <strong><?= htmlspecialchars($resumen['matricula'] . ' - ' . $resumen['alumno']) ?></strong>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Estatus</small>
                        <?php $activo = ($resumen['estatus'] === 'Activo'); ?>
                        <span class="badge <?= $activo ? 'text-bg-success' : 'text-bg-secondary' ?>">
                            <?= htmlspecialchars($resumen['estatus']) ?>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Promedio General</small>
                        <strong class="fs-5 text-primary"><?= htmlspecialchars((string)($resumen['promedio_general'] ?? '—')) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white mb-3">
            <thead class="table-dark">
                <tr>
                    <th>ID Calificación</th>
                    <th>ID Alumno</th>
                    <th>ID Materia</th>
                    <th>Materia</th>
                    <th>Unidad</th>
                    <th>Profesor</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($calificaciones) > 0): ?>
                    <?php foreach ($calificaciones as $c): ?>
                        <tr>
                            <td><?= (int)$c['id_calificacion'] ?></td>
                            <td><?= (int)$c['id_alumno'] ?></td>
                            <td><?= (int)$c['id_materia'] ?></td>
                            <td><?= htmlspecialchars($c['clave_mat'] . ' - ' . $c['materia']) ?></td>
                            <td><?= htmlspecialchars($c['unidad']) ?></td>
                            <td><?= htmlspecialchars($c['profesor']) ?></td>
                            <td><strong><?= htmlspecialchars($c['calificacion']) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">No tienes calificaciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <button type="button" onclick="window.print()" class="btn btn-primary btn-sm d-print-none">
        <i class="bi bi-printer-fill me-1"></i>Imprimir
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>