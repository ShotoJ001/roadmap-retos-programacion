<?php
require_once __DIR__ . "/../config/conexion.php";

$idMateria = (int)($_GET['id_materia'] ?? 0);

$materiasSelect = $conexion->query("SELECT id, clave_mat, nombre_mat, creditos, estatus
                                    FROM materias
                                    ORDER BY id ASC");

$sql = "SELECT m.id AS id_materia,
               m.clave_mat AS clave,
               COALESCE(a.matricula, '—') AS matricula,
               COALESCE(CONCAT_WS(' ', a.nombre, a.apaterno, a.amaterno), 'Sin asignar') AS alumno,
               m.nombre_mat AS materia,
               COALESCE(g.turno, '—') AS turno,
               m.creditos,
               COALESCE(CONCAT_WS(' ', p.nombre, p.apaterno, p.amaterno), 'Sin asignar') AS docente,
               m.estatus
        FROM materias m
        LEFT JOIN asignaciones asig ON asig.id_materia = m.id
        LEFT JOIN alumnos a ON asig.id_alumno = a.id
        LEFT JOIN profesores p ON asig.id_profesor = p.id
        LEFT JOIN inscripciones i ON i.id_alumno = a.id
        LEFT JOIN grupos g ON i.id_grupo = g.id";

if ($idMateria > 0) {
    $sql .= " WHERE m.id = $idMateria";
}
$sql .= " ORDER BY m.id ASC, a.id ASC";

$lista = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Materias</title>
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
            <label for="id_materia" class="form-label">Seleccionar Materia</label>
            <select id="id_materia" name="id_materia" class="form-select">
                <option value="">-- Todas las materias --</option>
                <?php if ($materiasSelect): ?>
                    <?php while ($m = $materiasSelect->fetch_assoc()): ?>
                        <option value="<?= (int)$m['id'] ?>" <?= $idMateria === (int)$m['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['clave_mat'] . ' - ' . $m['nombre_mat']) ?>
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
                    <th>Clave</th>
                    <th>Matrícula</th>
                    <th>Alumno</th>
                    <th>Materia</th>
                    <th>Turno</th>
                    <th>Créditos</th>
                    <th>Docente</th>
                    <th>Estatus</th>
                    <th class="d-print-none">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($lista && $lista->num_rows > 0): ?>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <?php $activo = ($r['estatus'] === 'Activo'); ?>
                    <tr>
                        <td><?= htmlspecialchars($r['clave']) ?></td>
                        <td><?= htmlspecialchars($r['matricula']) ?></td>
                        <td><?= htmlspecialchars($r['alumno']) ?></td>
                        <td><?= htmlspecialchars($r['materia']) ?></td>
                        <td><?= htmlspecialchars($r['turno']) ?></td>
                        <td><?= (int)$r['creditos'] ?></td>
                        <td><?= htmlspecialchars($r['docente']) ?></td>
                        <td>
                            <span class="badge <?= $activo ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                <?= htmlspecialchars($r['estatus']) ?>
                            </span>
                        </td>
                        <td class="d-print-none">
                            <a href="../formularios/modificar.php?tipo=materia&id=<?= (int)$r['id_materia'] ?>" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-3">No se encontraron registros de materias.</td>
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