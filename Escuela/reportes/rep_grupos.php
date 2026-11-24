<?php
require_once __DIR__ . "/../config/conexion.php";

$idGrupo = (int)($_GET['id_grupo'] ?? 0);

$gruposSelect = $conexion->query("SELECT id, clave_grupo, nombre_grupo, turno, estatus
                                  FROM grupos
                                  ORDER BY id ASC");

$sql = "SELECT a.id AS id_alumno,
               a.matricula,
               CONCAT_WS(' ', a.nombre, a.apaterno, a.amaterno) AS alumno,
               a.mail,
               a.tel,
               a.estatus,
               g.id AS id_grupo,
               g.clave_grupo,
               g.nombre_grupo,
               g.turno
        FROM inscripciones i
        INNER JOIN grupos g ON i.id_grupo = g.id
        INNER JOIN alumnos a ON i.id_alumno = a.id";

if ($idGrupo > 0) {
    $sql .= " WHERE g.id = $idGrupo";
}
$sql .= " ORDER BY g.id ASC, a.id ASC";

$lista = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Grupos</title>
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
            <label for="id_grupo" class="form-label">Seleccionar Grupo</label>
            <select id="id_grupo" name="id_grupo" class="form-select">
                <option value="">-- Todos los grupos --</option>
                <?php if ($gruposSelect): ?>
                    <?php while ($g = $gruposSelect->fetch_assoc()): ?>
                        <option value="<?= (int)$g['id'] ?>" <?= $idGrupo === (int)$g['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g['clave_grupo'] . ' - ' . $g['nombre_grupo'] . ' (' . $g['turno'] . ')') ?>
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
                    <th>Matrícula</th>
                    <th>Alumno</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Estatus</th>
                    <th class="d-print-none">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($lista && $lista->num_rows > 0): ?>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <?php $activo = ($r['estatus'] === 'Activo'); ?>
                    <tr>
                        <td><?= htmlspecialchars($r['matricula']) ?></td>
                        <td><?= htmlspecialchars($r['alumno']) ?></td>
                        <td><?= htmlspecialchars($r['mail']) ?></td>
                        <td><?= htmlspecialchars($r['tel']) ?></td>
                        <td>
                            <span class="badge <?= $activo ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                <?= htmlspecialchars($r['estatus']) ?>
                            </span>
                        </td>
                        <td class="d-print-none">
                            <a href="../formularios/modificar.php?tipo=alumno&id=<?= (int)$r['id_alumno'] ?>" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">No se encontraron registros en los grupos.</td>
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