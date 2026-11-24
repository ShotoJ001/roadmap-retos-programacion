<?php
require_once __DIR__ . "/../config/conexion.php";

if (isset($_GET['baja'])) {
    $id = (int)$_GET['baja'];
    $conexion->query("UPDATE unidades SET estatus = 'Inactivo', fecha_baja = NOW() WHERE id = $id");
    header("Location: CrudUnidad.php");
    exit;
}

$lista = $conexion->query("SELECT * FROM unidades WHERE estatus = 'Activo' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Unidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Unidades</h5>
            <a href="../baja/bajaUnidad.php" class="btn btn-warning btn-sm text-dark fw-semibold">Ver Bajas</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Unidad</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><?= htmlspecialchars($r['nombre_unidad']) ?></td>
                        <td><span class="badge text-bg-success"><?= htmlspecialchars($r['estatus']) ?></span></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="../formularios/alta.php?tipo=unidad" class="btn btn-success" title="Nueva Unidad">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                                <a href="../formularios/modificar.php?tipo=unidad&id=<?= (int)$r['id'] ?>" class="btn btn-primary" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="?baja=<?= (int)$r['id'] ?>" class="btn btn-danger" title="Dar de baja" onclick="return confirm('¿Dar de baja esta unidad?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </div>
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