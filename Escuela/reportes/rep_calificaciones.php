<?php
require_once __DIR__ . "/../config/conexion.php";

$idAlumno  = (int)($_GET['id_alumno'] ?? 0);


$alumnosSelect = $conexion->query("SELECT id, matricula, CONCAT_WS(' ', nombre, apaterno, amaterno) AS nombre_completo
                                   FROM alumnos
                                   ORDER BY id ASC");

$condiciones = [];
if ($idAlumno > 0) {
    $condiciones[] = "c.id_alumno = $idAlumno";
}

$sql = "SELECT c.id,
               a.matricula,
               m.clave_mat AS clave,
               CONCAT_WS(' ', a.nombre, a.apaterno, a.amaterno) AS nombre_completo,
               m.nombre_mat AS materia,
               u.nombre_unidad AS unidad,
               c.calificacion,
               a.estatus
        FROM calificaciones c
        INNER JOIN alumnos a ON c.id_alumno = a.id
        INNER JOIN materias m ON c.id_materia = m.id
        INNER JOIN unidades u ON c.id_unidad = u.id";

if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY c.id ASC";

$lista = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Calificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @media print {
            body {
                background-color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            nav {
                display: none !important;
            }
            .table thead th {
                background-color: #212529 !important;
                color: #ffffff !important;
            }
            .badge.text-bg-success {
                background-color: #198754 !important;
                color: #ffffff !important;
            }
            .badge.text-bg-secondary {
                background-color: #6c757d !important;
                color: #ffffff !important;
            }
        }
    </style>
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container py-4">
    <form method="GET" class="row g-3 align-items-end mb-4 d-print-none">
        <div class="col-md-10">
            <label for="id_alumno" class="form-label">Alumno Registrado</label>
            <select id="id_alumno" name="id_alumno" class="form-select">
                <option value="">-- Todos los alumnos --</option>
                <?php if ($alumnosSelect): ?>
                    <?php while ($al = $alumnosSelect->fetch_assoc()): ?>
                        <option value="<?= (int)$al['id'] ?>" <?= $idAlumno === (int)$al['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($al['matricula'] . ' - ' . $al['nombre_completo']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i>Buscar
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white mb-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Matrícula</th>
                    <th>Clave</th>
                    <th>Nombre Completo</th>
                    <th>Materia</th>
                    <th>Unidad</th>
                    <th>Calificación</th>
                    <th>Estatus</th>
                    <th class="d-print-none">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($lista && $lista->num_rows > 0): ?>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <?php $activo = ($r['estatus'] === 'Activo'); ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><?= htmlspecialchars($r['matricula']) ?></td>
                        <td><?= htmlspecialchars($r['clave']) ?></td>
                        <td><?= htmlspecialchars($r['nombre_completo']) ?></td>
                        <td><?= htmlspecialchars($r['materia']) ?></td>
                        <td><?= htmlspecialchars($r['unidad']) ?></td>
                        <td><?= htmlspecialchars($r['calificacion']) ?></td>
                        <td>
                            <span class="badge <?= $activo ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                <?= htmlspecialchars($r['estatus']) ?>
                            </span>
                        </td>
                        <td class="d-print-none">
                            <a href="../formularios/modificar.php?tipo=calificacion&id=<?= (int)$r['id'] ?>" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-3">No se encontraron calificaciones registradas.</td>
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