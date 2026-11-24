<?php
require_once __DIR__ . "/../config/conexion.php";

$nombre   = trim($_GET['nombre'] ?? '');
$apellido = trim($_GET['apellido'] ?? '');

$condiciones = [];
if ($nombre !== '') {
    $nombreEsc = $conexion->real_escape_string($nombre);
    $condiciones[] = "nombre LIKE '%$nombreEsc%'";
}
if ($apellido !== '') {
    $apellidoEsc = $conexion->real_escape_string($apellido);
    $condiciones[] = "(CONCAT_WS(' ', apaterno, amaterno) LIKE '%$apellidoEsc%' OR apaterno LIKE '%$apellidoEsc%' OR amaterno LIKE '%$apellidoEsc%')";
}

$sql = "SELECT id, matricula, CONCAT_WS(' ', nombre, apaterno, amaterno) AS alumno, mail, tel, estatus
        FROM alumnos";
if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY id ASC";

$lista = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Alumnos</title>
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
        <div class="col-md-5">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="form-control" placeholder="Buscar por nombre...">
        </div>
        <div class="col-md-5">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" class="form-control" placeholder="Buscar por apellido...">
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
                            <a href="../formularios/modificar.php?tipo=alumno&id=<?= (int)$r['id'] ?>" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">No se encontraron alumnos con ese criterio.</td>
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